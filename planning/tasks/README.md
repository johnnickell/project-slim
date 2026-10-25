# Implementation TASKs

The human maintainer approved the ten-slice decomposition of EPIC-00001. These records own implementation scope,
status, priority and TASK blockers. Readiness is not permission to begin implementation; confirm the execution
request and checkout/worktree choice first. Blocking is derived from unfinished edges, not stored as a status.

The [TASK Board](../tickets/BOARD.md) is the one execution entrypoint. This inventory includes all live and archived
TASKs, not a second execution frontier. Refresh marked projections explicitly with `./bin/planning-check --write`;
default validation rejects drift without writing. See [CONVENTIONS.md](../CONVENTIONS.md) and
[MIGRATION.md](../MIGRATION.md). Old IDs are not executable aliases.

<!-- planning:index:start -->
| Order | Record | Parent | Status | Dependency history | Unfinished blockers | Location |
| --- | --- | --- | --- | --- | --- | --- |
| 1 | [TASK-00001 — Migrate Planning to the New Schema](00001-TASK.md) | [TICKET-00007](../tickets/00007-TICKET.md) | done | — | — | live |
| 1 | [TASK-00017 — Require and Verify the Patched PHP Runtime](00017-TASK.md) | Standalone bug | done | — | — | live |
| 2 | [TASK-00002 — Generate Planning Views Safely](00002-TASK.md) | [TICKET-00007](../tickets/00007-TICKET.md) | done | [TASK-00001](00001-TASK.md) | — | live |
| 3 | [TASK-00003 — Establish Independent Review Handoffs](00003-TASK.md) | [TICKET-00007](../tickets/00007-TICKET.md) | done | [TASK-00001](00001-TASK.md) | — | live |
| 4 | [TASK-00004 — Establish Ownership and PHP Conventions](00004-TASK.md) | [TICKET-00008](../tickets/00008-TICKET.md) | done | [TASK-00001](00001-TASK.md) | — | live |
| 5 | [TASK-00005 — Retire Framework Certification](00005-TASK.md) | [TICKET-00009](../tickets/00009-TICKET.md) | done | [TASK-00001](00001-TASK.md) | — | live |
| 6 | [TASK-00006 — Qualify Released Dependencies](00006-TASK.md) | [TICKET-00010](../tickets/00010-TICKET.md) | done | [TASK-00005](00005-TASK.md) | — | live |
| 7 | [TASK-00007 — Make Development Runtime Worktree-Safe](00007-TASK.md) | [TICKET-00011](../tickets/00011-TICKET.md) | done | [TASK-00001](00001-TASK.md) | — | live |
| 8 | [TASK-00008 — Align Behavior Suites and Coverage](00008-TASK.md) | [TICKET-00011](../tickets/00011-TICKET.md) | done | [TASK-00006](00006-TASK.md), [TASK-00007](00007-TASK.md) | — | live |
| 9 | [TASK-00009 — Deliver the Canonical Quality Gate](00009-TASK.md) | [TICKET-00011](../tickets/00011-TICKET.md) | done | [TASK-00002](00002-TASK.md), [TASK-00003](00003-TASK.md), [TASK-00004](00004-TASK.md), [TASK-00008](00008-TASK.md) | — | live |
| 10 | [TASK-00010 — Sanitize HTTP Failures](00010-TASK.md) | [TICKET-00012](../tickets/00012-TICKET.md) | ready-for-agent | [TASK-00009](00009-TASK.md) | — | live |
| — | [TASK-00011 — Establish the Governed Slim Starter Foundation](00011-TASK.md) | [TICKET-00013](../tickets/00013-TICKET.md) | done | — | — | live |
| — | [TASK-00012 — Adopt Fight Common 1.2](00012-TASK.md) | [TICKET-00014](../tickets/00014-TICKET.md) | done | — | — | live |
| — | [TASK-00013 — Prepare Fight Common 2.0 Migration](00013-TASK.md) | [TICKET-00014](../tickets/00014-TICKET.md) | needs-info | — | — | live |
| — | [TASK-00014 — Re-certify Rewritten Fight Common Candidate](00014-TASK.md) | [TICKET-00014](../tickets/00014-TICKET.md) | done | — | — | live |
| — | [TASK-00015 — Establish the Requirement, Task, and Review Planning Surface](00015-TASK.md) | [TICKET-00015](../tickets/00015-TICKET.md) | wontfix | — | — | live |
| — | [TASK-00016 — Establish the Lean Slim Pre-Submit Quality Gate](00016-TASK.md) | [TICKET-00014](../tickets/00014-TICKET.md) | wontfix | — | — | live |
| — | [TASK-00018 — Keep Delivery Handoffs Fresh After Merge](00018-TASK.md) | Standalone bug | in-progress | — | — | live |
<!-- planning:index:end -->

## Delivery and migrated history

TASK-00017's independently accepted and QA-passed PHP runtime repair merged through
[PR #15](https://github.com/johnnickell/project-slim/pull/15) at `922b55f`.
Land reconciled it with accepted TASK-00003/00004/00006 in combined
[PR #16](https://github.com/johnnickell/project-slim/pull/16), now merged at `9778ee53aeda451c7993caee81feae72f604aa0b`.
TASK-00001's independently accepted reconciliation merged through PR #12 at `eec7d06`.
TASK-00007 retains lifecycle modernization; this planning-tooling slice makes no runtime changes.

TASK-00011/00012/00014 retain historical completion evidence, not fresh verification.
TASK-00015 and TASK-00016 preserve different historical T-00006 sources, not duplicate identities in this schema.
TASK-00015 is the superseded, unimplemented bootstrap proposal. The 2026-10-24 adoption amendment resolves
TASK-00016's scope/coverage conflict without a duplicate gate. TASK-00008/00009 retain the adopted coverage policy;
their implementation is not claimed. TASK-00013's Common 2.0 information gate remains unresolved.

Completed blocker edges remain in source as history. No TASK is independently accepted, published or merged merely
because it appears here. Archive apply/link repair remains dynamically unexercised; no actual archive is authorized
by implementing tooling.
