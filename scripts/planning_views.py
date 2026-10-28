"""Deterministic marked projections; authored narrative stays outside the markers."""

from __future__ import annotations

from dataclasses import replace
import os
from pathlib import Path
import re
from typing import TYPE_CHECKING

if TYPE_CHECKING:
    from planning_portfolio import Record

TERMINAL = {"done", "wontfix"}


def ordered(records):
    return sorted(records, key=lambda record: (
        not bool(record.data.get("order")), int(record.data.get("order") or "0"), record.identifier,
    ))


def live(record) -> bool:
    return record.path.parent.name != "archive"


def cell(value: str) -> str:
    return value.replace("|", "&#124;").replace("[", "&#91;").replace("]", "&#93;")


def link(record, source: Path, title: bool = False) -> str:
    label = record.identifier + (" — " + record.data["title"] if title else "")
    return f"[{cell(label)}]({os.path.relpath(record.path, source.parent)})"


def table(headers: list[str], rows: list[list[str]]) -> str:
    if not rows:
        return "None."
    return "\n".join("| " + " | ".join(row) + " |" for row in [
        headers, ["---"] * len(headers), *rows,
    ])


def routing_summary(groups, records, source: Path) -> str:
    """Share authoritative Board selection with summaries; never infer delivery or execution authority."""
    selected = [("Needs Info / Human Action", task) for task in groups["info"]]
    if groups["active"]:
        selected.extend(("Active Work", task) for task in groups["active"])
    elif groups["ready"]:
        selected.append(("Ready Frontier", groups["ready"][0]))
    elif groups["waiting"]:
        selected.append(("Waiting", groups["waiting"][0]))
    body = table(["Route", "TASK", "Status", "Unfinished blockers"], [
        [name, link(task, source, True), task.data["status"],
         ", ".join(link(records[key], source) for key in task.blockers
                   if records[key].data["status"] not in TERMINAL) or "—"]
        for name, task in selected
    ])
    if not groups["active"] and not groups["ready"]:
        body += "\n\nNo TASK is currently executable; unresolved work may remain."
    return body


def marked(text: str, name: str, body: str, path: Path) -> str:
    # All pairs must be flat and ordered; nested/crossed blocks could erase authored text.
    opened = None
    for marker in re.finditer(r"<!-- planning:([a-z-]+):(start|end) -->", text):
        label, direction = marker.groups()
        if direction == "start":
            if opened is not None:
                raise ValueError(f"{path}: nested planning markers")
            opened = label
        elif opened != label:
            raise ValueError(f"{path}: mismatched planning markers")
        else:
            opened = None
    if opened is not None:
        raise ValueError(f"{path}: unterminated planning markers")
    start, end = f"<!-- planning:{name}:start -->", f"<!-- planning:{name}:end -->"
    if text.count(start) != 1 or text.count(end) != 1:
        raise ValueError(f"{path}: expected exactly one {name} marker pair")
    before, rest = text.split(start)
    if end not in rest:
        raise ValueError(f"{path}: reversed {name} markers")
    _, after = rest.split(end)
    return before + start + "\n" + body + "\n" + end + after


def refresh_plan(records: dict[str, Record], documents: dict[Path, str] | None = None) -> dict[Path, str]:
    # Imported here to avoid making the validator and renderer mutually dependent at import time.
    from planning_portfolio import PLANNING

    original = {} if documents is None else documents
    pending: dict[Path, str] = {}

    def read(path):
        if path in pending:
            return pending[path]
        if path in original:
            return original[path]
        return path.read_text(encoding="utf-8")

    def project(path, name, body):
        pending[path] = marked(read(path), name, body, path)

    records = dict(records)
    # Bottom-up, including archived children, but never changing terminal/archived parents.
    for kind, parent_field in (("TICKET", "ticket"), ("EPIC", "epic")):
        for parent in ordered(record for record in records.values() if record.kind == kind):
            children = [record for record in records.values() if record.data.get(parent_field) == parent.identifier]
            if (not live(parent) or parent.data["status"] in TERMINAL or not children
                    or any(child.data["status"] not in TERMINAL for child in children)):
                continue
            status = "wontfix" if all(child.data["status"] == "wontfix" for child in children) else "done"
            pending[parent.path] = re.sub(r"^status: .*?$", f"status: {status}", read(parent.path), count=1, flags=re.MULTILINE)
            records[parent.identifier] = replace(parent, data={**parent.data, "status": status})

    def blockers(record, source, unfinished=False):
        return ", ".join(link(records[identifier], source) for identifier in record.blockers
                         if not unfinished or records[identifier].data["status"] not in TERMINAL) or "—"

    def parent_link(record, source):
        identifier = record.data.get("ticket", record.data.get("epic", ""))
        return link(records[identifier], source) if identifier else "Standalone " + record.data["kind"]

    def rows(items, source):
        return [[record.data.get("order") or "—", link(record, source, True), parent_link(record, source),
                 record.data["status"], blockers(record, source), blockers(record, source, True),
                 "live" if live(record) else "archived"] for record in ordered(items)]

    headers = ["Order", "Record", "Parent", "Status", "Dependency history", "Unfinished blockers", "Location"]
    for kind, directory in (("TASK", "tasks"), ("TICKET", "tickets")):
        path = PLANNING / directory / "README.md"
        project(path, "index", table(headers, rows([r for r in records.values() if r.kind == kind], path)))

    epics = ordered(record for record in records.values() if record.kind == "EPIC")
    path = PLANNING / "epics/README.md"
    epic_headers = ["Epic", "Target", "Status", "Location"]

    def epic_rows(items, source):
        return [[link(record, source, True), cell(record.data["target"]), record.data["status"],
                 "live" if live(record) else "archived"] for record in items]

    project(path, "index", table(epic_headers, epic_rows(epics, path)))
    for parent in records.values():
        if parent.kind not in {"EPIC", "TICKET"}:
            continue
        field = "epic" if parent.kind == "EPIC" else "ticket"
        children = [record for record in records.values() if record.data.get(field) == parent.identifier]
        project(parent.path, "children", table(headers, rows(children, parent.path)))

    path = PLANNING / "tickets/BOARD.md"
    tasks = ordered(record for record in records.values() if record.kind == "TASK" and live(record))

    def unfinished(record):
        return any(records[identifier].data["status"] not in TERMINAL for identifier in record.blockers)

    groups = {
        "active": [r for r in tasks if r.data["status"] == "in-progress"],
        "ready": [r for r in tasks if r.data["status"] == "ready-for-agent" and not unfinished(r)],
        "waiting": [r for r in tasks if r.data["status"] == "ready-for-agent" and unfinished(r)],
        "info": [r for r in tasks if r.data["status"] in {"needs-info", "needs-triage", "ready-for-human"}],
        "closed": [r for r in tasks if r.data["status"] in TERMINAL],
    }
    for name, items in groups.items():
        project(path, name, table(headers, rows(items, path)))
    project(path, "next", routing_summary(groups, records, path))

    path = PLANNING / "ROADMAP.md"
    project(path, "execution", routing_summary(groups, records, path))
    project(path, "active-epics", table(epic_headers, epic_rows([r for r in epics if r.data["status"] not in TERMINAL], path)))
    project(path, "closed-epics", table(epic_headers, epic_rows([r for r in epics if r.data["status"] in TERMINAL], path)))
    return {path: text for path, text in pending.items()
            if text != (original[path] if path in original else path.read_text(encoding="utf-8"))}
