# Implementation TASKs

The human maintainer approved the ten-slice decomposition of EPIC-00001. These records own implementation scope,
status, priority, and TASK blockers. Readiness is not permission to begin implementation; confirm the execution
request and checkout/worktree choice first. Blocking is derived from unfinished edges, not stored as a status.

This index is manually maintained until TASK-00002 implements generated views. The
[current Board](../tickets/BOARD.md) remains the execution entrypoint. See
[CONVENTIONS.md](../CONVENTIONS.md) for the new-only schema and [MIGRATION.md](../MIGRATION.md) for historical provenance.
Old IDs are not executable aliases; all work records now use EPIC/TICKET/TASK.

| Order | TASK | Parent requirement | Status | TASK blockers |
| --- | --- | --- | --- | --- |
| 1 | [TASK-00001 — Migrate Planning to the New Schema](00001-TASK.md) | [TICKET-00007](../tickets/00007-TICKET.md) | done; independent review pending | — |
| 2 | [TASK-00002 — Generate Planning Views Safely](00002-TASK.md) | [TICKET-00007](../tickets/00007-TICKET.md) | ready-for-agent | [TASK-00001](00001-TASK.md) |
| 3 | [TASK-00003 — Establish Independent Review Handoffs](00003-TASK.md) | [TICKET-00007](../tickets/00007-TICKET.md) | ready-for-agent | [TASK-00001](00001-TASK.md) |
| 4 | [TASK-00004 — Establish Ownership and PHP Conventions](00004-TASK.md) | [TICKET-00008](../tickets/00008-TICKET.md) | ready-for-agent | [TASK-00001](00001-TASK.md) |
| 5 | [TASK-00005 — Retire Framework Certification](00005-TASK.md) | [TICKET-00009](../tickets/00009-TICKET.md) | ready-for-agent | [TASK-00001](00001-TASK.md) |
| 6 | [TASK-00006 — Qualify Released Dependencies](00006-TASK.md) | [TICKET-00010](../tickets/00010-TICKET.md) | ready-for-agent | [TASK-00005](00005-TASK.md) |
| 7 | [TASK-00007 — Make Development Runtime Worktree-Safe](00007-TASK.md) | [TICKET-00011](../tickets/00011-TICKET.md) | ready-for-agent | [TASK-00001](00001-TASK.md) |
| 8 | [TASK-00008 — Align Behavior Suites and Coverage](00008-TASK.md) | [TICKET-00011](../tickets/00011-TICKET.md) | ready-for-agent | [TASK-00006](00006-TASK.md), [TASK-00007](00007-TASK.md) |
| 9 | [TASK-00009 — Deliver the Canonical Quality Gate](00009-TASK.md) | [TICKET-00011](../tickets/00011-TICKET.md) | ready-for-agent | [TASK-00002](00002-TASK.md), [TASK-00003](00003-TASK.md), [TASK-00004](00004-TASK.md), [TASK-00008](00008-TASK.md) |
| 10 | [TASK-00010 — Sanitize HTTP Failures](00010-TASK.md) | [TICKET-00012](../tickets/00012-TICKET.md) | ready-for-agent | [TASK-00009](00009-TASK.md) |

## Migrated Work

| TASK | Parent requirement | Status | Blockers |
| --- | --- | --- | --- |
| [TASK-00011 — Establish the Governed Slim Starter Foundation](00011-TASK.md) | [TICKET-00013](../tickets/00013-TICKET.md) | done (historical) | — |
| [TASK-00012 — Adopt Fight Common 1.2](00012-TASK.md) | [TICKET-00014](../tickets/00014-TICKET.md) | done (historical) | — |
| [TASK-00013 — Prepare Fight Common 2.0 Migration](00013-TASK.md) | [TICKET-00014](../tickets/00014-TICKET.md) | needs-info | — |
| [TASK-00014 — Re-certify Rewritten Fight Common Candidate](00014-TASK.md) | [TICKET-00014](../tickets/00014-TICKET.md) | done (historical) | — |
| [TASK-00015 — Establish the Requirement, Task, and Review Planning Surface](00015-TASK.md) | [TICKET-00015](../tickets/00015-TICKET.md) | wontfix | — |

The checker validates the new schema read-only. Explicit refresh/drift checking and archive tooling belong to
TASK-00002; `--write` is rejected and archive execution is disabled. Indexes/Board remain manually maintained.
Completed blocker edges stay in source records as history and do not prevent downstream execution.
No TASK is implemented, independently accepted, published, or merged merely because it appears in this index.
