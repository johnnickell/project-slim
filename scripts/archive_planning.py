#!/usr/bin/env python3
"""Plan explicit new-schema archives; apply only a reviewed, unchanged dry-run digest."""

from __future__ import annotations

import argparse
from dataclasses import replace
from difflib import unified_diff
import hashlib
import os
from pathlib import Path
import re
import sys
from urllib.parse import quote, unquote, urlsplit, urlunsplit

# Keep read-only usage/refusals free of source-directory bytecode artifacts.
sys.dont_write_bytecode = True

from planning_portfolio import (
    DIRECTORIES, MARKDOWN_LINK, PLANNING, ROOT, TERMINAL, load_records,
    markdown_documents, validate_links, validate_relationships,
)
from planning_views import refresh_plan


def section(text: str, heading: str) -> str:
    matches = list(re.finditer(rf"^## {re.escape(heading)}\s*\n(.*?)(?=^## |\Z)", text, re.MULTILINE | re.DOTALL))
    if len(matches) != 1:
        raise ValueError(f"expected exactly one {heading} section")
    return matches[0].group(1).strip()


def local_target(source: Path, target: str) -> Path | None:
    url = urlsplit(target)
    if url.scheme or url.netloc or not url.path:
        return None
    path = unquote(url.path)
    return (ROOT / path.lstrip("/") if path.startswith("/") else source.parent / path).resolve()


def wayfinder_moves(selector: str, documents: dict[Path, str], records) -> dict[Path, Path]:
    if not re.fullmatch(r"[a-z0-9]+(?:-[a-z0-9]+)*-map", selector):
        raise ValueError("Wayfinder selector must be an exact map basename without .md")
    base = PLANNING / "wayfinder"
    path = base / f"{selector}.md"
    text = documents.get(path, "")
    if not re.search(r"^\*\*Label:\*\* `wayfinder:map`$", text, re.MULTILINE):
        raise ValueError("selection is not a live Wayfinder map")
    if re.findall(r"^\*\*Status:\*\* (.+)$", text, re.MULTILINE) != ["Closed"]:
        raise ValueError("Wayfinder map must be Closed")
    if section(text, "Frontier") not in {"None", "None.", "—"}:
        raise ValueError("Wayfinder Frontier must explicitly be None or —")
    resolution = section(text, "Resolution")
    handoff = {local_target(path, target) for target in MARKDOWN_LINK.findall(resolution)}
    if not all(any(record.path in handoff and record.kind == kind for record in records.values())
               for kind in ("EPIC", "TICKET", "TASK")):
        raise ValueError("Wayfinder Resolution must link its EPIC, TICKET and TASK implementation handoff")
    decisions = {local_target(path, target) for target in MARKDOWN_LINK.findall(text)}
    decisions = {target for target in decisions if target and target.parent == base / "tickets"
                 and re.fullmatch(r"WF-[0-9]{3}-.+\.md", target.name)}
    if not decisions:
        raise ValueError("Wayfinder map must link decision tickets")
    moves = {path: base / "archive" / path.name}
    for decision in sorted(decisions):
        body = documents.get(decision, "")
        if re.findall(r"^\*\*Status:\*\* (.+)$", body, re.MULTILINE) != ["Closed"]:
            raise ValueError(f"Wayfinder decision must be Closed: {decision.relative_to(ROOT)}")
        if not section(body, "Resolution"):
            raise ValueError("Wayfinder decision has no resolution")
        # A shared decision belongs to another map too: do not silently move its authority.
        for other, other_text in documents.items():
            if other.parent == base and other != path and "`wayfinder:map`" in other_text:
                if any(local_target(other, target) == decision for target in MARKDOWN_LINK.findall(other_text)):
                    raise ValueError(f"decision is shared with another live map: {other.name}")
        moves[decision] = base / "archive/tickets" / decision.name
    # Linked research is evidence, never a second decision store. Move only directly linked research.
    for source in (path, *sorted(decisions)):
        for target in MARKDOWN_LINK.findall(documents[source]):
            research = local_target(source, target)
            if research and research.parent == base / "research" and research in documents:
                moves[research] = base / "archive/research" / research.name
    return moves


def select_moves(mode: str, selectors: list[str], records, documents) -> dict[Path, Path]:
    if len(selectors) != len(set(selectors)):
        raise ValueError("duplicate selectors are ambiguous")
    if mode == "wayfinder":
        if len(selectors) != 1:
            raise ValueError("select exactly one Wayfinder map")
        return wayfinder_moves(selectors[0], documents, records)
    kind = {directory: kind for kind, directory in DIRECTORIES.items()}[mode]
    moves = {}
    for identifier in selectors:
        if not re.fullmatch(rf"{kind}-[0-9]{{5}}", identifier):
            raise ValueError(f"expected exact {kind}-NNNNN identity; no legacy aliases: {identifier}")
        record = records.get(identifier)
        if record is None or record.path.parent != PLANNING / mode:
            raise ValueError(f"not a live {kind}: {identifier}")
        if record.data["status"] not in TERMINAL:
            raise ValueError(f"record is not terminal: {identifier}")
        if kind != "TASK":
            field = "epic" if kind == "EPIC" else "ticket"
            children = [child for child in records.values() if child.data.get(field) == identifier]
            if any(child.data["status"] not in TERMINAL for child in children):
                raise ValueError(f"record has unfinished children: {identifier}")
        moves[record.path] = record.path.parent / "archive" / record.path.name
    return moves


def repair_links(text: str, old_source: Path, new_source: Path, moves: dict[Path, Path]) -> str:
    def repair(match):
        target = match.group(1)
        destination = local_target(old_source, target)
        if destination is None:
            return match.group(0)
        relocated = moves.get(destination, destination)
        if relocated == destination and old_source == new_source:
            return match.group(0)
        url = urlsplit(target)
        path = ("/" + relocated.relative_to(ROOT).as_posix() if url.path.startswith("/")
                else os.path.relpath(relocated, new_source.parent))
        replacement = urlunsplit(("", "", quote(path, safe="/-._~"), url.query, url.fragment))
        start, end = match.span(1)
        offset = match.start()
        return match.group(0)[:start - offset] + replacement + match.group(0)[end - offset:]

    return MARKDOWN_LINK.sub(repair, text)


def archive_plan(mode, selectors):
    documents = markdown_documents()
    if any(path.is_symlink() for path in documents):
        raise ValueError("archive refuses symlinked Markdown")
    errors = []
    records = load_records(errors)
    validate_relationships(records, errors)
    validate_links(errors, documents)
    if errors:
        raise ValueError("invalid portfolio: " + "; ".join(errors))
    if refresh_plan(records, documents):
        raise ValueError("planning views/parents are stale; explicitly refresh before archive")
    moves = select_moves(mode, selectors, records, documents)
    destinations = set()
    for source, destination in moves.items():
        if source not in documents:
            raise ValueError(f"source is not repository-owned Markdown: {source}")
        # Check directories too: never follow a symlink into another resource or overwrite any case variant.
        for ancestor in (destination, *destination.parents):
            if ancestor.is_symlink():
                raise ValueError(f"symlink in archive destination: {ancestor}")
        if destination.exists() or (destination.parent.exists() and any(
                sibling.name.casefold() == destination.name.casefold() for sibling in destination.parent.iterdir())):
            raise ValueError(f"archive destination occupied: {destination}")
        normalized = str(destination).casefold()
        if normalized in destinations:
            raise ValueError("case-insensitive destination collision")
        destinations.add(normalized)
    proposed = {moves.get(source, source): repair_links(text, source, moves.get(source, source), moves)
                for source, text in documents.items()}
    relocated = {identifier: replace(record, path=moves.get(record.path, record.path))
                 for identifier, record in records.items()}
    proposed.update(refresh_plan(relocated, proposed))
    errors = []
    checked = load_records(errors, proposed)
    validate_relationships(checked, errors)
    validate_links(errors, proposed)
    if errors or refresh_plan(checked, proposed):
        raise ValueError("prospective archive validation failed: " + "; ".join(errors))
    changes = {path: text for path, text in proposed.items() if documents.get(path) != text}
    digest = hashlib.sha256()
    # Bind confirmation to all read input, selected moves and exact proposed bytes.
    for label, entries in (("input", documents), ("output", proposed)):
        for path, text in sorted(entries.items()):
            digest.update(f"{label}\0{path.relative_to(ROOT)}\0{text}\0".encode("utf-8"))
    return documents, moves, changes, digest.hexdigest()


def apply_plan(documents, moves, changes):
    # Detect concurrent edits before any mutation. Roll back owned bytes on an I/O/validation failure.
    if markdown_documents() != documents:
        raise ValueError("Markdown changed since planning; rerun the dry run")
    written = []
    removed = []
    try:
        for destination in moves.values():
            if destination.exists() or destination.is_symlink():
                raise ValueError(f"archive destination changed since planning: {destination}")
        for path, text in changes.items():
            path.parent.mkdir(parents=True, exist_ok=True)
            written.append(path)
            path.write_text(text, encoding="utf-8")
        for source in moves:
            source.unlink()
            removed.append(source)
        errors = []
        records = load_records(errors)
        validate_relationships(records, errors)
        validate_links(errors)
        if errors or refresh_plan(records):
            raise ValueError("post-archive validation failed: " + "; ".join(errors))
    except (OSError, UnicodeError, ValueError):
        for source in removed:
            source.write_text(documents[source], encoding="utf-8")
        for path in reversed(written):
            if path in documents:
                path.write_text(documents[path], encoding="utf-8")
            else:
                path.unlink(missing_ok=True)
        raise


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__, allow_abbrev=False,
        epilog="No legacy selectors. No implicit archives. Review the dry-run moves/rewrites, then repeat the same selection with --apply --confirm DIGEST.")
    parser.add_argument("mode", choices=["tasks", "tickets", "epics", "wayfinder"])
    parser.add_argument("selectors", nargs="+", help="exact new-schema IDs, or one map basename without .md")
    parser.add_argument("--apply", action="store_true", help="explicit authority to apply the reviewed plan")
    parser.add_argument("--confirm", help="SHA-256 digest printed by the prior dry run; required with --apply")
    args = parser.parse_args()
    try:
        if args.apply != bool(args.confirm):
            raise ValueError("--apply and --confirm DIGEST must be supplied together after a reviewed dry run")
        documents, moves, changes, digest = archive_plan(args.mode, args.selectors)
        for source, destination in sorted(moves.items()):
            print(f"MOVE {source.relative_to(ROOT)} -> {destination.relative_to(ROOT)}")
        reverse_moves = {destination: source for source, destination in moves.items()}
        for path in sorted(changes):
            print(f"WRITE {path.relative_to(ROOT)}")
            source = reverse_moves.get(path, path)
            print("".join(unified_diff(documents.get(source, "").splitlines(keepends=True),
                                       changes[path].splitlines(keepends=True),
                                       fromfile=str(source.relative_to(ROOT)),
                                       tofile=str(path.relative_to(ROOT)))), end="")
        print(f"Plan digest: {digest}")
        if args.apply:
            if args.confirm != digest:
                raise ValueError("confirmation does not match this plan; review a fresh dry run")
            apply_plan(documents, moves, changes)
            print("Archive applied; read-only planning validation passed. Inspect and commit moves and link repairs together.")
        else:
            print("Dry run only. No files changed. Inspect the listed moves and rewrites before explicit apply.")
        return 0
    except (OSError, UnicodeError, ValueError) as exception:
        print(f"Archive refused: {exception}", file=sys.stderr)
        return 2


if __name__ == "__main__":
    sys.exit(main())
