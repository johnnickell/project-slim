# Requirements

TICKETs own requirements under an EPIC and decompose into separately approved TASKs; they are not executable work.
Only EPIC/TICKET/TASK is supported. [MIGRATION.md](../MIGRATION.md) accounts for old PRD/T-ticket history without parser
aliases or duplicate status authorities. [CONVENTIONS.md](../CONVENTIONS.md) defines the schema and tooling boundaries.

Status, priority and dependencies belong to records. Explicit `./bin/planning-check --write` refreshes the marked
projection; default validation is read-only and rejects drift. The [TASK Board](BOARD.md) is the execution entrypoint.
Dependency history is distinct from unfinished blockers; requirement blockers are never copied onto every child TASK.

<!-- planning:index:start -->
| Order | Record | Parent | Status | Dependency history | Unfinished blockers | Location |
| --- | --- | --- | --- | --- | --- | --- |
| 1 | [TICKET-00007 — Consistent Planning and Independent Review](00007-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | done | — | — | live |
| 2 | [TICKET-00008 — Explicit Application Ownership and PHP Standards](00008-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | done | — | — | live |
| 3 | [TICKET-00009 — Single-Lock Development Without Framework Certification](00009-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | done | — | — | live |
| 4 | [TICKET-00010 — Qualified Released Dependency Baseline](00010-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | done | [TICKET-00009](00009-TICKET.md) | — | live |
| 5 | [TICKET-00011 — Reproducible Runtime and One Quality Gate](00011-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | in-progress | [TICKET-00007](00007-TICKET.md), [TICKET-00008](00008-TICKET.md), [TICKET-00009](00009-TICKET.md), [TICKET-00010](00010-TICKET.md) | — | live |
| 6 | [TICKET-00012 — Safe and Predictable HTTP Failures](00012-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | ready-for-agent | [TICKET-00008](00008-TICKET.md), [TICKET-00010](00010-TICKET.md), [TICKET-00011](00011-TICKET.md) | [TICKET-00011](00011-TICKET.md) | live |
| — | [TICKET-00013 — Slim Starter Product and Walking-Slice Acceptance](00013-TICKET.md) | [EPIC-00002](../epics/00002-EPIC.md) | done | — | — | live |
| — | [TICKET-00014 — Fight Common Version Adoption and Support Evidence](00014-TICKET.md) | [EPIC-00003](../epics/00003-EPIC.md) | in-progress | — | — | live |
| — | [TICKET-00015 — Planning and Review Transition for Engineering Alignment](00015-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | wontfix | — | — | live |
<!-- planning:index:end -->

## Delivery and provenance

TASK-00001's accepted reconciliation merged through PR #12 at `eec7d06`.
TASK-00003/00004/00006 have independent acceptance and QA PASS; combined
[PR #16](https://github.com/johnnickell/project-slim/pull/16) merged at `9778ee53aeda451c7993caee81feae72f604aa0b`.
TICKET-00008/00010 completed with their sole children. TASK-00016's scope/coverage conflict was resolved by the explicit
adoption amendment, not by schema conversion. TASK-00002 supplies generation/archive tooling and completes
TICKET-00007 only after its required local acceptance verification; review, QA and publication remain separate.

Old IDs are provenance only. New-schema archive tooling requires an explicit request and reviewed dry run before
apply; no migration or completion authorizes an archive. TASK-00002 performs none and discloses unexercised apply paths.
