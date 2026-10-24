# TASK Execution Board

## Routing index

Read only current human decisions and active work below; otherwise the first ready TASK.
Use [lightweight routing](../CONVENTIONS.md#lightweight-work-routing) for validation and evidence limits.
[Wayfinder status and frontiers](../wayfinder/README.md) answer the decision-routing question.
Use the [Roadmap](../ROADMAP.md) and current handoffs for planning phases; do not infer full decomposition from closed maps.
Read the referenced current section, not the full historical record. Missing handoff/phase needs owner input.

Record metadata owns status, priority, and blockers. This manually maintained view routes to TASKs only.
Requirements are not executable work; see the [requirement index](README.md). Generated views and drift detection
remain TASK-00002 work. [MIGRATION.md](../MIGRATION.md) distinguishes historical source identities, not execution aliases.

## "What's Next?" Contract

1. **Human decision:** return the item under **Now** when it still requires judgment.
2. **Implementation:** return all TASKs under **Active Work**; only when none are active, return the first TASK under
   **Ready Frontier**. Report none when both sections are empty.
3. If unqualified, return both targets. Never choose by number alone or treat completed dependency edges as unresolved.

## Now

[TASK-00003](../tasks/00003-TASK.md), [TASK-00004](../tasks/00004-TASK.md) and
[TASK-00006](../tasks/00006-TASK.md) are implemented on `feature/slim-foundation-adoption`, awaiting independent
review and applicable QA before separately authorized publication. Canonical build passes (26 tests / 152 assertions);
completion is not independent acceptance or delivery. No review/QA report or PR is claimed for this branch.

The maintainer selected one-to-one non-domain adoption in [EPIC-00001](../epics/00001-EPIC.md#current-adoption-amendment--2026-10-24).
TASK-00016 is superseded as wontfix: TASK-00008/00009 own the adopted coverage/gate implementation. No policy decision
is still required there. PR #12 is already merged into local `develop` at `eec7d06`; its former merge request is stale,
not a reason to merge again. No fresh hosted-check result is inferred.

New-only validation works; generated views/`--write` and archive execution remain undelivered. Common 2.0 remains
needs-info in TASK-00013.

## Active Work

None. Implemented work awaiting independent review is named under Now, not a new implementation assignment.

## Current Planning Handoff

The approved alignment decomposition is complete; use its existing TASKs. The full AccessControl map remains at
paused WF-002. Revisit frontend/authentication adoption through WF-005/WF-009 once the source flow is complete;
no new EPIC/TICKET/TASK decomposition is currently approved or inferred from this bounded adoption.

## Wayfinder Review

[Slim AccessControl Application](../wayfinder/slim-access-control-application-map.md) remains active. Its one current
frontier is [WF-002 — Local Development Runtime Contract](../wayfinder/tickets/WF-002-local-development-runtime-contract.md),
open but paused pending Fight Agent OS direction on shared resources, worktree test isolation, and ingress
integration. Partial decisions are recorded in WF-002; no Wayfinder review candidate is currently available.
This planning pause does not change TASK scopes or the implementation frontier.

## Ready Frontier

Completed TASK-00001 edges remain as history and no longer block these TASKs. TASK-00002 is the first ready successor;
readiness never grants execution authority automatically.

| Order | TASK | Parent requirement | Unfinished TASK blockers |
| --- | --- | --- | --- |
| 2 | [TASK-00002 — Generate Planning Views Safely](../tasks/00002-TASK.md) | [TICKET-00007](00007-TICKET.md) | — |
| 7 | [TASK-00007 — Make Development Runtime Worktree-Safe](../tasks/00007-TASK.md) | [TICKET-00011](00011-TICKET.md) | — |

## Waiting

All statuses below are ready-for-agent; unfinished TASK dependencies derive their waiting state.

| Order | TASK | Parent requirement | Unfinished TASK blockers |
| --- | --- | --- | --- |
| 8 | [TASK-00008 — Align Behavior Suites and Coverage](../tasks/00008-TASK.md) | [TICKET-00011](00011-TICKET.md) | TASK-00007 |
| 9 | [TASK-00009 — Deliver the Canonical Quality Gate](../tasks/00009-TASK.md) | [TICKET-00011](00011-TICKET.md) | TASK-00002, TASK-00008 |
| 10 | [TASK-00010 — Sanitize HTTP Failures](../tasks/00010-TASK.md) | [TICKET-00012](00012-TICKET.md) | TASK-00009 |

Requirement-level dependencies are not automatically blockers on every child TASK. Completed TASK edges stay in
metadata as history, not unresolved blockers. TASK-00016's scope/coverage decision is resolved; its implementation
belongs to TASK-00008/00009, not a duplicate gate.

## Needs Info

| TASK | Parent requirement | Missing decision or evidence |
| --- | --- | --- |
| [TASK-00013 — Prepare Fight Common 2.0 Migration](../tasks/00013-TASK.md) | [TICKET-00014](00014-TICKET.md) | Common 2.0 contract, deprecation-removal inventory, and migration guide. |

## Recently Closed / Done

TASK-00003/00004/00006 have fresh local implementation evidence but no independent acceptance yet. TASK-00001 and
older entries retain their historical verification/delivery evidence; completion alone never implies publication or merge.

| TASK | Parent requirement | Outcome |
| --- | --- | --- |
| [TASK-00003 — Establish Independent Review Handoffs](../tasks/00003-TASK.md) | [TICKET-00007](00007-TICKET.md) | done: shared workflow binding, canonical reports and routing walkthroughs; independent review/QA pending. |
| [TASK-00004 — Establish Ownership and PHP Conventions](../tasks/00004-TASK.md) | [TICKET-00008](00008-TICKET.md) | done: ADR/standards and sorted callable shared-bus modules; 14 module contracts qualified, retained suite/build pass. |
| [TASK-00006 — Qualify Released Dependencies](../tasks/00006-TASK.md) | [TICKET-00010](00010-TICKET.md) | done: Common v1.4.0 / AccessControl v0.8.0; bounded security patch; strict validation/audit/build pass. |
| [TASK-00016 — Establish the Lean Slim Pre-Submit Quality Gate](../tasks/00016-TASK.md) | [TICKET-00014](00014-TICKET.md) | wontfix: duplicate gate scope assigned to alignment slices; Agent OS coverage policy adopted, not yet implemented. |
| [TASK-00005 — Retire Framework Certification](../tasks/00005-TASK.md) | [TICKET-00009](00009-TICKET.md) | done: certification files/readers/tests retired; single-lock build passes 26 tests / 152 assertions; review and hosted checks separate. |
| [TASK-00001 — Migrate Planning to the New Schema](../tasks/00001-TASK.md) | [TICKET-00007](00007-TICKET.md) | done: reconciled schema independently accepted at 6203941; preservation checks and canonical build pass; [PR #12](https://github.com/johnnickell/project-slim/pull/12) merged in local develop at eec7d06; no new hosted claim. |
| [TASK-00015 — Establish the Requirement, Task, and Review Planning Surface](../tasks/00015-TASK.md) | [TICKET-00015](00015-TICKET.md) | wontfix: bootstrap-first sequence superseded without implementation; not PR #11's lean-gate handoff. |
| [TASK-00014 — Re-certify Rewritten Fight Common Candidate](../tasks/00014-TASK.md) | [TICKET-00014](00014-TICKET.md) | done: historical tree-equivalent candidate recertification, lock/receipt digests, and canonical build. |
| [TASK-00012 — Adopt Fight Common 1.2](../tasks/00012-TASK.md) | [TICKET-00014](00014-TICKET.md) | done: historical exact candidate/local-safe profile and receipt gates. |
| [TASK-00011 — Establish the Governed Slim Starter Foundation](../tasks/00011-TASK.md) | [TICKET-00013](00013-TICKET.md) | done: historical local/hosted gate receipts and accepted foundation handoff. |
