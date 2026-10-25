"""Bounded live delivery observations and explicit retirement; offline checks never call GitHub."""

from __future__ import annotations

from dataclasses import replace
import datetime
import json
import os
from pathlib import Path
import re
import subprocess
from typing import TYPE_CHECKING

if TYPE_CHECKING:
    from planning_portfolio import Record


def current_delivery(records: dict[str, Record]) -> list[Record]:
    """Select explicit live publication snapshots, never status, PR URLs or historical prose."""
    return [record for _, record in sorted(records.items())
            if record.data.get("delivery") == "awaiting-merge"]


def delivery_identity(records: dict[str, Record]) -> tuple[list[Record], str | None, list[str]]:
    from planning_portfolio import ROOT

    handoffs = current_delivery(records)
    if not handoffs:
        return handoffs, None, []
    if len(handoffs) > 16:
        return handoffs, None, ["at most 16 current delivery handoffs may be verified per invocation"]
    try:
        origin = local_git("remote", "get-url", "origin")
    except (OSError, subprocess.SubprocessError):
        return handoffs, None, ["delivery identity incomplete: cannot read target origin; planning owner must resolve it"]
    match = re.fullmatch(r"(?:git@github\.com:|https://github\.com/)([A-Za-z0-9_.-]+/[A-Za-z0-9_.-]+?)(?:\.git)?", origin)
    if not match:
        return handoffs, None, ["delivery identity incomplete: origin must identify one GitHub repository"]
    repository = match[1]
    errors = []
    for record in handoffs:
        if not re.fullmatch(rf"https://github\.com/{re.escape(repository)}/pull/[1-9][0-9]*", record.data["pr"]):
            errors.append(f"{record.path.relative_to(ROOT)} ({record.identifier}): delivery PR identity does not match target origin")
    return handoffs, repository, errors


def local_git(*arguments: str) -> str:
    """Inspect local objects only, without replacement ancestry or partial-clone fetching."""
    from planning_portfolio import ROOT

    return subprocess.run(
        ["git", "--no-replace-objects", "-c", f"safe.directory={ROOT}", *arguments],
        cwd=ROOT, capture_output=True, text=True, timeout=5, check=True,
        env={**os.environ, "GIT_NO_LAZY_FETCH": "1"},
    ).stdout.strip()


def verify_delivery(handoffs: list[Record], repository: str | None) -> tuple[list[tuple[Record, dict]], list[str]]:
    """Resolve only exact merged, already-done and locally integrated publication snapshots."""
    from planning_portfolio import ROOT

    resolved, errors = [], []
    for record in handoffs:
        identifier, data = record.identifier, record.data
        label = f"{record.path.relative_to(ROOT)} ({identifier})"
        number = int(data["pr"].rsplit("/", 1)[1])
        try:
            result = subprocess.run(
                ["gh", "pr", "view", str(number), "--repo", repository, "--json",
                 "number,url,title,state,isDraft,mergedAt,baseRefName,headRefName,headRefOid,mergeCommit"],
                cwd=ROOT, capture_output=True, text=True, timeout=15, check=True,
                env={**os.environ, "GH_PROMPT_DISABLED": "1"},
            )
            if len(result.stdout) > 16384:
                raise ValueError("oversized metadata")
            pr = json.loads(result.stdout)
            if (not isinstance(pr, dict) or type(pr.get("number")) is not int or pr["number"] != number
                    or pr.get("url") != data["pr"] or pr.get("title") != identifier + " — " + data["title"]
                    or pr.get("baseRefName") != "develop"
                    or not isinstance(pr.get("headRefName"), str)
                    or not re.fullmatch(rf"feature/task-{identifier[5:]}-[a-z0-9][a-z0-9-]*", pr["headRefName"])
                    or not isinstance(pr.get("headRefOid"), str)
                    or not re.fullmatch(r"[0-9a-f]{40}", pr["headRefOid"])):
                raise ValueError("identity mismatch")
            state = pr.get("state")
            if (state not in {"OPEN", "MERGED", "CLOSED"} or type(pr.get("isDraft")) is not bool
                    or "mergedAt" not in pr or "mergeCommit" not in pr):
                raise ValueError("invalid state")
            if state == "MERGED":
                if not isinstance(pr["mergedAt"], str) or not re.fullmatch(r"\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z", pr["mergedAt"]):
                    raise ValueError("invalid merge time")
                datetime.datetime.fromisoformat(pr["mergedAt"].replace("Z", "+00:00"))
                commit = pr["mergeCommit"]
                if (not isinstance(commit, dict) or not isinstance(commit.get("oid"), str)
                        or not re.fullmatch(r"[0-9a-f]{40}", commit["oid"])):
                    raise ValueError("invalid merge commit")
                if data["status"] != "done":
                    errors.append(f"{label}: PR #{number} is MERGED but TASK is not done; resolve TASK scope before routing")
                    continue
                try:
                    local_head = local_git("rev-parse", "--verify", "HEAD^{commit}")
                    local_git("merge-base", "--is-ancestor", pr["headRefOid"], commit["oid"])
                    local_git("merge-base", "--is-ancestor", commit["oid"], local_head)
                except (OSError, subprocess.SubprocessError):
                    errors.append(f"{label}: PR #{number} is MERGED but local integration is UNVERIFIED; obtain/integrate the exact merge through authorized Git work, then rerun. No fetch or merge was performed")
                    continue
                pr["localHead"] = local_head
                resolved.append((record, pr))
                print(f"Delivery resolved: {identifier} PR #{number} is MERGED and locally integrated ({commit['oid']}); no human merge or cleanup request remains.")
            elif pr["mergedAt"] is not None or pr["mergeCommit"] is not None:
                raise ValueError("contradictory merge evidence")
            elif state == "CLOSED":
                errors.append(f"{label}: PR #{number} is CLOSED WITHOUT MERGE; planning owner must decide its disposition")
            elif pr["isDraft"]:
                print(f"Delivery fresh: {identifier} PR #{number} is OPEN/draft; resume Land for its recorded delivery prerequisites, not human merge.")
            else:
                print(f"Delivery fresh: {identifier} PR #{number} is OPEN; human review/merge remains pending.")
        except (OSError, subprocess.SubprocessError, ValueError, TypeError):
            # Raw CLI/API diagnostics may contain credentials; retain only the safe prerequisite.
            errors.append(f"{label}: delivery verification INCOMPLETE (tooling/authentication/API/metadata or identity unavailable); planning owner must recover authoritative evidence. No merge or fresh pass is inferred")
    return resolved, errors


def reconcile_delivery(records: dict[str, Record], resolved: list[tuple[Record, dict]]) -> dict[Path, str]:
    """Plan lossless marker retirement and exact evidence before any file is written."""
    from planning_portfolio import frontmatter

    pending = {}
    observed = datetime.datetime.now(datetime.timezone.utc).strftime("%Y-%m-%dT%H:%M:%SZ")
    for record, pr in resolved:
        text = record.path.read_bytes().decode("utf-8")
        header, boundary, body = re.split(r"((?:\r\n|\r|\n)---(?:\r\n|\r|\n))", text, maxsplit=1)
        end = boundary.index("---")
        header = "".join(line for line in (header + boundary[:end]).splitlines(keepends=True)
                         if line.partition(":")[0].strip() != "delivery")
        retired = header + boundary[end:] + body
        expected = {key: value for key, value in record.data.items() if key != "delivery"}
        if frontmatter(retired) != expected:
            raise ValueError(f"{record.identifier}: delivery retirement did not preserve expected frontmatter")
        pending[record.path] = retired + "\n\n" + (
            f"### Delivery reconciliation — PR #{pr['number']}\n\n"
            f"Observed {observed}: {pr['url']} is MERGED into `{pr['baseRefName']}` at "
            f"`{pr['mergedAt']}`. Published head `{pr['headRefOid']}` is an ancestor of merge "
            f"`{pr['mergeCommit']['oid']}`, which is integrated in local HEAD `{pr['localHead']}`. "
            "Retired the ended delivery marker; implementation acceptance/QA and historical publication "
            "remain separate. No approval, merge, release or deployment was performed by reconciliation.\n"
        )
        records[record.identifier] = replace(record, data=expected)
    return pending
