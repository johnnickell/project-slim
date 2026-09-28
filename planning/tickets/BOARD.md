# TASK Execution Board

Record metadata owns status, priority, and blockers. This manually maintained view routes to TASKs only.
Requirements are not executable work; see the [requirement index](README.md). Generated views and drift detection
remain TASK-00002 work. [MIGRATION.md](../MIGRATION.md) maps historical IDs, not supported execution aliases.

## "What's Next?" Contract

1. **Human decision:** return the item under **Now** when it still requires judgment.
2. **Implementation:** return the first TASK under **Ready Frontier**; report none when that section is empty.
3. If unqualified, return both targets. Never choose by number alone or treat completed dependency edges as unresolved.

## Now

Obtain independent Spec/Standards review of [TASK-00001](../tasks/00001-TASK.md)'s committed snapshot. It is locally
complete on the authorized current checkout/branch, `feature/engineering-alignment-planning`, with approved planning
preserved and a green canonical build. No review acceptance, publication, merge, archive, or release is claimed.

[TASK-00002](../tasks/00002-TASK.md) is the first ready implementation successor, not an automatic instruction to start.
New-only validation works; generated views/`--write` and archive tooling remain undelivered. Archives are disabled.
Common 2.0 remains needs-info in TASK-00013.

## Wayfinder Review

[Slim AccessControl Application](../wayfinder/slim-access-control-application-map.md) remains active. Its one current
frontier is [WF-002 — Local Development Runtime Contract](../wayfinder/tickets/WF-002-local-development-runtime-contract.md),
the unblocked HITL decision for the complete worktree-safe local Docker and environment contract. Schema migration
changed vocabulary, not product decision status or authority.

## Ready Frontier

Completed TASK-00001 edges remain in the records but no longer block these TASKs.

| Order | TASK | Parent requirement | Unfinished TASK blockers |
| --- | --- | --- | --- |
| 2 | [TASK-00002 — Generate Planning Views Safely](../tasks/00002-TASK.md) | [TICKET-00007](00007-TICKET.md) | — |
| 3 | [TASK-00003 — Establish Independent Review Handoffs](../tasks/00003-TASK.md) | [TICKET-00007](00007-TICKET.md) | — |
| 4 | [TASK-00004 — Establish Ownership and PHP Conventions](../tasks/00004-TASK.md) | [TICKET-00008](00008-TICKET.md) | — |
| 5 | [TASK-00005 — Retire Framework Certification](../tasks/00005-TASK.md) | [TICKET-00009](00009-TICKET.md) | — |
| 7 | [TASK-00007 — Make Development Runtime Worktree-Safe](../tasks/00007-TASK.md) | [TICKET-00011](00011-TICKET.md) | — |

## Waiting

All statuses below are ready-for-agent; unfinished TASK dependencies derive their waiting state.

| Order | TASK | Parent requirement | Unfinished TASK blockers |
| --- | --- | --- | --- |
| 6 | [TASK-00006 — Qualify Released Dependencies](../tasks/00006-TASK.md) | [TICKET-00010](00010-TICKET.md) | TASK-00005 |
| 8 | [TASK-00008 — Align Behavior Suites and Coverage](../tasks/00008-TASK.md) | [TICKET-00011](00011-TICKET.md) | TASK-00006, TASK-00007 |
| 9 | [TASK-00009 — Deliver the Canonical Quality Gate](../tasks/00009-TASK.md) | [TICKET-00011](00011-TICKET.md) | TASK-00002, TASK-00003, TASK-00004, TASK-00008 |
| 10 | [TASK-00010 — Sanitize HTTP Failures](../tasks/00010-TASK.md) | [TICKET-00012](00012-TICKET.md) | TASK-00009 |

Requirement-level dependencies are not automatically blockers on every child TASK.

## Needs Info

| TASK | Parent requirement | Missing evidence |
| --- | --- | --- |
| [TASK-00013 — Prepare Fight Common 2.0 Migration](../tasks/00013-TASK.md) | [TICKET-00014](00014-TICKET.md) | Common 2.0 contract, deprecation-removal inventory, and migration guide. |

## Recently Closed / Done

TASK-00001 has fresh local evidence, not independent acceptance. The other entries retain historical evidence.

| TASK | Parent requirement | Outcome |
| --- | --- | --- |
| [TASK-00001 — Migrate Planning to the New Schema](../tasks/00001-TASK.md) | [TICKET-00007](00007-TICKET.md) | done: migrated with provenance, new-only validation and canonical build pass; independent review pending. |
| [TASK-00015 — Establish the Requirement, Task, and Review Planning Surface](../tasks/00015-TASK.md) | [TICKET-00015](00015-TICKET.md) | wontfix: bootstrap-first sequence superseded without implementation; continuing work belongs to TICKET-00007. |
| [TASK-00014 — Re-certify Rewritten Fight Common Candidate](../tasks/00014-TASK.md) | [TICKET-00014](00014-TICKET.md) | done: historical tree-equivalent candidate recertification, lock/receipt digests, and canonical build. |
| [TASK-00012 — Adopt Fight Common 1.2](../tasks/00012-TASK.md) | [TICKET-00014](00014-TICKET.md) | done: historical exact candidate/local-safe profile and receipt gates. |
| [TASK-00011 — Establish the Governed Slim Starter Foundation](../tasks/00011-TASK.md) | [TICKET-00013](00013-TICKET.md) | done: historical local/hosted gate receipts and accepted foundation handoff. |
