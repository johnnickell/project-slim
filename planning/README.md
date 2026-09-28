# Planning

This directory is the committed source of truth for Fight Slim Starter planning. The only supported work hierarchy
is `EPIC -> TICKET -> TASK`; requirements and implementation records have distinct authority.

- `ROADMAP.md` records strategic progress.
- `epics/` describes destinations.
- `tickets/` owns requirements under `TICKET-NNNNN` identities.
- `tasks/` owns bounded implementation under `TASK-NNNNN` identities and their approved dependency graph.
- `tickets/BOARD.md` is the current execution entrypoint for TASKs; generation is still pending.
- `adr/` records architectural decisions.
- `agents/` contains focused working instructions.
- `wayfinder/` holds planning-only investigation maps and decision records, not executable work.

[MIGRATION.md](MIGRATION.md) maps the removed PRD/T-ticket paths to their new records, preserving historical outcomes,
unresolved information gates, and supersession evidence. Old IDs are provenance only, not parser aliases. There is no
compatibility parser, legacy execution frontier, or legacy archive mode. TASK-00001's implementation/verification
status remains separate from independent review. The mapping distinguishes the two historical T-00006 sources:
the wontfix bootstrap is TASK-00015; PR #11's lean-gate handoff is TASK-00016 under TICKET-00014, needs-info for
scope/coverage reconciliation. No old identity or path is retained as an executable compatibility record.

Use copy-ready `_…_TEMPLATE.md` files beside records. IDs have five digits and separate sequences for EPICs, TICKETs,
and TASKs; preserve gaps and avoid live/archive identity and path collisions or reusing historical allocations.
Requirements are not executable merely because they are ready. Blocking is derived from unfinished dependency edges.

`CONVENTIONS.md` defines metadata, lifecycle, authority, and the migration boundary. Preserve historical meaning through
provenance and link repair, not dual mutable records. Archive only on explicit request using the owning new-schema
command once implemented; schema migration does not authorize moving records into archives.

Run `./bin/planning-check` after planning changes: it validates only EPIC/TICKET/TASK and local Markdown file targets,
read-only. Heading anchors are not validated. There is no `--write` or drift detection yet; unsupported options fail.
TASK-00002 owns generated views and new-schema archive tooling. The archive command is disabled (exit 2, no mutation).
Direct checks are not the full canonical gate; do not commit or publish with a failing required gate. Scratch belongs
in ignored `.runs/`, never here.
