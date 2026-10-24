# Requirements

TICKETs own requirements under an EPIC and decompose into separately approved TASKs; they are not executable work.
Only EPIC/TICKET/TASK is supported. [MIGRATION.md](../MIGRATION.md) accounts for old PRD/T-ticket history without parser
aliases or duplicate status authorities. [CONVENTIONS.md](../CONVENTIONS.md) defines the schema and tooling limits.

Status, priority, and dependency edges belong to records. These manually maintained tables are not generated yet.
The [TASK Board](BOARD.md) is the execution entrypoint; [TASKs](../tasks/README.md) carry implementation blockers.

## Engineering Alignment — EPIC-00001

| Order | Requirement | Outcome | Status | Requirement blockers |
| --- | --- | --- | --- | --- |
| 1 | [TICKET-00007](00007-TICKET.md) | Consistent Planning and Independent Review | in-progress | — |
| 2 | [TICKET-00008](00008-TICKET.md) | Explicit Application Ownership and PHP Standards | done | — |
| 3 | [TICKET-00009](00009-TICKET.md) | Single-Lock Development Without Framework Certification | done | — |
| 4 | [TICKET-00010](00010-TICKET.md) | Qualified Released Dependency Baseline | done | TICKET-00009 |
| 5 | [TICKET-00011](00011-TICKET.md) | Reproducible Runtime and One Quality Gate | ready-for-agent | TICKET-00007, TICKET-00008, TICKET-00009, TICKET-00010 |
| 6 | [TICKET-00012](00012-TICKET.md) | Safe and Predictable HTTP Failures | ready-for-agent | TICKET-00008, TICKET-00010, TICKET-00011 |

The alignment TASKs retain their dependency edges as history. TASK-00001's accepted reconciliation is merged in
local develop through PR #12 at `eec7d06`. TASK-00003/00004/00006 have independent acceptance and QA PASS; combined publication is pending;
TICKET-00008/00010 complete with their sole children. TICKET-00007 stays open for TASK-00002, the first ready successor.
TASK-00016's scope/coverage conflict is resolved by the explicit adoption amendment, not by schema conversion.

## Migrated Requirements

| Requirement | Parent | Outcome | Status |
| --- | --- | --- | --- |
| [TICKET-00013](00013-TICKET.md) | [EPIC-00002](../epics/00002-EPIC.md) | Slim Starter Product and Walking-Slice Acceptance | done (historical) |
| [TICKET-00014](00014-TICKET.md) | [EPIC-00003](../epics/00003-EPIC.md) | Fight Common Version Adoption and Support Evidence | in-progress; Common 2.0 preparation needs information; TASK-00016 superseded |
| [TICKET-00015](00015-TICKET.md) | [EPIC-00001](../epics/00001-EPIC.md) | Planning and Review Transition for Engineering Alignment | wontfix; superseded before implementation |

Old IDs are provenance only. Archive execution is disabled pending TASK-00002, which supplies new-schema tooling;
actual archiving still requires a separate explicit request. No schema migration or completion authorizes an archive.
