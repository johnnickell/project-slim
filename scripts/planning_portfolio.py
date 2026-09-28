#!/usr/bin/env python3
"""Read-only validation of Slim's EPIC -> TICKET -> TASK Markdown portfolio."""

from __future__ import annotations

import argparse
from dataclasses import dataclass
from pathlib import Path
import re
import subprocess
import sys
from urllib.parse import unquote, urlsplit

ROOT = Path(__file__).resolve().parents[1]
PLANNING = ROOT / "planning"
VALID_STATUSES = {
    "needs-triage", "needs-info", "ready-for-agent", "ready-for-human",
    "in-progress", "done", "wontfix",
}
TERMINAL = {"done", "wontfix"}
DIRECTORIES = {"EPIC": "epics", "TICKET": "tickets", "TASK": "tasks"}
FIELDS = {
    "EPIC": {"id", "title", "status", "target"},
    "TICKET": {"id", "epic", "title", "status", "order", "blocked_by"},
    "TASK": {"id", "ticket", "kind", "title", "status", "order", "blocked_by", "pr"},
}
TEMPLATES = {
    PLANNING / directory / f"_{kind}_TEMPLATE.md"
    for kind, directory in DIRECTORIES.items()
}
IDENTITY = re.compile(r"(EPIC|TICKET|TASK)-([0-9]{5})")
MARKDOWN_LINK = re.compile(r"!?\[[^\]]*\]\(([^\s)]+)")


@dataclass(frozen=True)
class Record:
    path: Path
    kind: str
    data: dict[str, str]

    @property
    def identifier(self) -> str:
        return self.data["id"]

    @property
    def blockers(self) -> list[str]:
        value = self.data.get("blocked_by", "")
        return [part.strip() for part in value.split(",")] if value else []


def frontmatter(text: str) -> dict[str, str]:
    """Read the documented flat scalar metadata, rejecting ambiguous syntax."""
    lines = text.splitlines()
    if not lines or lines[0] != "---":
        raise ValueError("missing frontmatter")
    try:
        end = lines.index("---", 1)
    except ValueError as exception:
        raise ValueError("unterminated frontmatter") from exception
    values: dict[str, str] = {}
    for line in lines[1:end]:
        if not line.strip():
            continue
        match = re.fullmatch(r"([a-z][a-z_]*):\s*(.*)", line)
        if not match:
            raise ValueError(f"expected a flat scalar metadata field: {line!r}")
        key, value = match.groups()
        if key in values:
            raise ValueError(f"duplicate metadata field: {key}")
        # This is deliberately not a general YAML reader: no lists, block scalars,
        # aliases, implicit booleans, quoted strings, or inline comments.
        if value.startswith(("'", '"', "[", "{", "|", ">", "&", "*", "!", "#")) or " #" in value:
            raise ValueError(f"{key} must use an unquoted single-line scalar")
        values[key] = value.strip()
    return values


def is_work_record(path: Path, text: str) -> bool:
    if path in TEMPLATES:
        return False
    if re.search(r"-(EPIC|TICKET|TASK|PRD)\.md$", path.name):
        return True
    if not text.startswith("---\n"):
        return False
    header = text.split("\n---", 1)[0]
    directory = path.relative_to(PLANNING).parts[0]
    # Discover misplaced records too; ADRs and WF decisions are not work records.
    return directory in {*DIRECTORIES.values(), "specs"} or bool(
        re.search(r"^id:\s*['\"]?(?:EPIC|TICKET|TASK|PRD|T)-", header, re.MULTILINE)
    )


def load_records(errors: list[str]) -> dict[str, Record]:
    records: dict[str, Record] = {}
    paths: set[str] = set()
    for path in sorted(PLANNING.rglob("*.md")):
        text = path.read_text(encoding="utf-8")
        if not is_work_record(path, text):
            continue
        label = str(path.relative_to(ROOT))
        if path.is_symlink():
            errors.append(f"{label}: work records cannot be symlinks")
            continue
        try:
            data = frontmatter(text)
        except ValueError as exception:
            errors.append(f"{label}: {exception}")
            continue
        identifier = data.get("id", "")
        identity = IDENTITY.fullmatch(identifier)
        if not identity:
            errors.append(f"{label}: unsupported id {identifier!r}; only EPIC/TICKET/TASK are supported")
            continue
        kind, number = identity.groups()
        record = Record(path, kind, data)
        directory = PLANNING / DIRECTORIES[kind]
        if path.parent not in (directory, directory / "archive") or path.name != f"{number}-{kind}.md":
            errors.append(f"{label}: {identifier} must use {DIRECTORIES[kind]}/[archive/]{number}-{kind}.md")
        normalized = label.casefold()
        if normalized in paths:
            errors.append(f"{label}: case-insensitive record path collision")
        paths.add(normalized)
        if identifier in records:
            errors.append(f"{label}: duplicate id {identifier} (also {records[identifier].path.relative_to(ROOT)})")
        else:
            records[identifier] = record
        for field in sorted(FIELDS[kind] - data.keys()):
            errors.append(f"{label}: missing metadata field {field}")
        allowed = FIELDS[kind] | ({"standalone_reason"} if kind == "TASK" else set())
        for field in sorted(data.keys() - allowed):
            errors.append(f"{label}: unsupported metadata field {field}")
        for field in ("id", "title", "status", "target") if kind == "EPIC" else ("id", "title", "status"):
            if not data.get(field):
                errors.append(f"{label}: {field} must not be empty")
        if data.get("status") not in VALID_STATUSES:
            errors.append(f"{label}: invalid status {data.get('status')!r}")
        if data.get("order") and not re.fullmatch(r"[1-9][0-9]*", data["order"]):
            errors.append(f"{label}: order must be empty or a positive decimal integer")
        if kind == "TASK":
            if data.get("kind") not in {"feature", "bug", "chore"}:
                errors.append(f"{label}: invalid TASK kind {data.get('kind')!r}")
            if not data.get("ticket") and (
                data.get("kind") not in {"bug", "chore"} or not data.get("standalone_reason")
            ):
                errors.append(f"{label}: standalone TASK requires bug/chore kind and nonempty standalone_reason")
            if data.get("ticket") and data.get("standalone_reason"):
                errors.append(f"{label}: standalone_reason is only valid without a parent ticket")
            if data.get("pr") and not re.fullmatch(r"https?://[^\s]+", data["pr"]):
                errors.append(f"{label}: pr must be empty or an HTTP(S) URL")
    if not records:
        errors.append("planning/: no supported work records found")
    return records


def validate_relationships(records: dict[str, Record], errors: list[str]) -> None:
    for record in records.values():
        label = str(record.path.relative_to(ROOT))
        if record.kind != "EPIC":
            parent_field, parent_kind = ("epic", "EPIC") if record.kind == "TICKET" else ("ticket", "TICKET")
            parent_id = record.data.get(parent_field, "")
            if parent_id or record.kind == "TICKET":
                parent = records.get(parent_id)
                if parent is None or parent.kind != parent_kind:
                    errors.append(f"{label}: {parent_field} must name an existing {parent_kind}: {parent_id!r}")
        if len(record.blockers) != len(set(record.blockers)):
            errors.append(f"{label}: duplicate blocked_by edge")
        for identifier in record.blockers:
            blocker = records.get(identifier)
            if blocker is None or blocker.kind != record.kind:
                errors.append(f"{label}: blocker must name an existing {record.kind}: {identifier!r}")

    visiting: set[str] = set()
    visited: set[str] = set()

    def visit(identifier: str) -> None:
        if identifier in visiting:
            errors.append(f"dependency cycle at {identifier}")
            return
        if identifier in visited or identifier not in records:
            return
        visiting.add(identifier)
        for blocker in records[identifier].blockers:
            visit(blocker)
        visiting.remove(identifier)
        visited.add(identifier)

    for identifier in sorted(records):
        visit(identifier)


def git(*args: str) -> subprocess.CompletedProcess[str]:
    return subprocess.run(
        ["git", "-c", f"safe.directory={ROOT}", *args], cwd=ROOT,
        text=True, capture_output=True, check=False,
    )


def validate_links(errors: list[str]) -> None:
    # Include root/contributor documentation as well as planning; exclude ignored
    # vendor, scratch, and other worktrees instead of traversing the whole disk.
    result = git("ls-files", "--cached", "--others", "--exclude-standard", "-z", "--", "*.md")
    if result.returncode:
        errors.append("cannot enumerate repository-owned Markdown through git ls-files")
        return
    for name in sorted(set(filter(None, result.stdout.split("\0")))):
        path = ROOT / name
        if not path.is_file() or path.name.endswith("_TEMPLATE.md"):
            continue
        for target in MARKDOWN_LINK.findall(path.read_text(encoding="utf-8")):
            try:
                url = urlsplit(target)
            except ValueError:
                errors.append(f"{name}: malformed Markdown target {target!r}")
                continue
            if url.scheme or url.netloc or not url.path:
                continue
            destination = unquote(url.path)
            if not destination.endswith(".md"):
                continue
            resolved = ROOT / destination.lstrip("/") if destination.startswith("/") else path.parent / destination
            if not resolved.is_file():
                errors.append(f"{name}: broken local Markdown link {target}")


def main() -> int:
    parser = argparse.ArgumentParser(
        description=__doc__, allow_abbrev=False,
        epilog="No refresh/write mode is implemented. Generated views and archive tooling belong to TASK-00002.",
    )
    parser.parse_args()
    errors: list[str] = []
    try:
        records = load_records(errors)
        validate_relationships(records, errors)
        validate_links(errors)
    except (OSError, UnicodeError) as exception:
        print(f"Planning validation failed: {exception}", file=sys.stderr)
        return 1
    if git("check-ignore", "-q", ".runs/planning-check").returncode:
        errors.append(".runs/ must be gitignored")
    if errors:
        print("Planning validation failed:")
        for error in errors:
            print(f"- {error}")
        return 1

    active = sum(record.data["status"] not in TERMINAL for record in records.values())
    tasks = [record for record in records.values() if record.kind == "TASK"]
    unfinished = {
        task.identifier: [identifier for identifier in task.blockers if records[identifier].data["status"] not in TERMINAL]
        for task in tasks
    }
    ready = sorted(
        (task for task in tasks if task.data["status"] == "ready-for-agent" and not unfinished[task.identifier]),
        key=lambda task: (int(task.data["order"]) if task.data["order"] else float("inf"), task.identifier),
    )
    print(f"Planning validation passed: {len(records)} records, {active} active, {len(tasks)} TASKs")
    print("Ready TASKs (unfinished edges only): " + (", ".join(task.identifier for task in ready) or "None"))
    return 0


if __name__ == "__main__":
    sys.exit(main())
