# Planning

This directory is the committed source of truth for Fight Slim Starter planning. The only supported work hierarchy
is `EPIC -> TICKET -> TASK`; requirements and implementation records have distinct authority.

- `ROADMAP.md` records strategic progress.
- `epics/` describes destinations.
- `tickets/` owns requirements under `TICKET-NNNNN` identities.
- `tasks/` owns bounded implementation under `TASK-NNNNN` identities and their approved dependency graph.
- `tickets/BOARD.md` is the sole execution entrypoint for TASKs; its marked projections derive from records.
- `adr/` records architectural decisions.
- `agents/` contains focused working instructions.
- `wayfinder/` holds planning-only investigation maps and decision records, not executable work.

[MIGRATION.md](MIGRATION.md) maps the removed PRD/T-ticket paths to their new records, preserving historical outcomes,
unresolved information gates, and supersession evidence. Old IDs are provenance only, not parser aliases. There is no
compatibility parser, legacy execution frontier, or legacy archive mode. TASK-00001's implementation/verification
status remains separate from independent review. The mapping distinguishes the two historical T-00006 sources:
the wontfix bootstrap is TASK-00015; PR #11's distinct lean-gate handoff is TASK-00016 under TICKET-00014, now
superseded as wontfix by the explicit 2026-10-24 adoption scope/coverage decision. No old identity or path is retained as an executable compatibility record.

The [shared workflow binding](../docs/engineering/WORKFLOWS.md) supplies Slim paths, tooling substitutions and
independent delivery/report responsibilities. TASK-00003/00004/00006 are integrated through merged PR #16. TASK-00002 supplies generation and new-only archive
tooling; worktree-safe runtime, suite/coverage, expanded gate and safe HTTP adoption remain separately tracked.

Use copy-ready `_…_TEMPLATE.md` files beside records. IDs have five digits and separate sequences for EPICs, TICKETs,
and TASKs; preserve gaps and avoid live/archive identity and path collisions or reusing historical allocations.
Requirements are not executable merely because they are ready. Blocking is derived from unfinished dependency edges.

`CONVENTIONS.md` defines metadata, lifecycle, authority, and the migration boundary. Preserve historical meaning through
provenance and link repair, not dual mutable records. Archive only on explicit request using the owning new-schema
command once implemented; schema migration does not authorize moving records into archives.

After authorized planning edits, run `./bin/planning-check --write` to validate first, complete eligible parents
bottom-up and refresh marked sections. Then run `./bin/planning-check`: it validates EPIC/TICKET/TASK, local Markdown
file targets and view freshness without writing. Heading anchors are not validated; unsupported options fail.
Build invokes only the read-only mode. Keep strategy, decisions and delivery evidence outside generated markers.
The new-only archive command requires a separate explicit request, reviewed dry run and matching confirmation digest;
see [archive rules](CONVENTIONS.md#archive-explicit-requests-only). TASK-00002 performs no archives, so archive
apply/link repair remains dynamically unexercised. Direct checks are not the full canonical gate; do not commit or
publish with a failing required gate. Scratch belongs in ignored `.runs/`, never here.
