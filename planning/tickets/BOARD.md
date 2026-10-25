# TASK Execution Board

## Routing index

Read only current human decisions and active work below; otherwise the first ready TASK.
Use [lightweight routing](../CONVENTIONS.md#lightweight-work-routing) for validation and evidence limits.
[Wayfinder status and frontiers](../wayfinder/README.md) answer the decision-routing question.
Use the [Roadmap](../ROADMAP.md) and current handoffs for planning phases; do not infer full decomposition from closed maps.
Read the referenced current section, not the full historical record. Missing handoff/phase needs owner input.

Record metadata owns status, priority, and blockers. Marked sections are generated TASK-only views.
Use `./bin/planning-check --write` to refresh explicitly; `./bin/planning-check` rejects drift without writing.
Requirements are not executable work; see the [requirement index](README.md). [MIGRATION.md](../MIGRATION.md) distinguishes historical source identities, not execution aliases.

## "What's Next?" Contract

1. **Human decision:** return the item under **Now** when it still requires judgment.
2. **Implementation:** return all TASKs under **Active Work**; only when none are active, return the first TASK under
   **Ready Frontier**. Report none when both sections are empty.
3. If unqualified, return both targets. Never choose by number alone or treat completed dependency edges as unresolved.

## Current TASK Routing

<!-- planning:next:start -->
| Route | TASK | Status | Unfinished blockers |
| --- | --- | --- | --- |
| Needs Info / Human Action | [TASK-00013 — Prepare Fight Common 2.0 Migration](../tasks/00013-TASK.md) | needs-info | — |
| Ready Frontier | [TASK-00010 — Sanitize HTTP Failures](../tasks/00010-TASK.md) | ready-for-agent | — |
<!-- planning:next:end -->

## Current Delivery Handoffs

These are recorded publication snapshots, not live merge claims. Run
`./bin/planning-check --check-delivery` before routing; verified merged/integrated handoffs resolve read-only.

<!-- planning:delivery:start -->
| TASK | Current delivery | PR |
| --- | --- | --- |
| [TASK-00018 — Keep Delivery Handoffs Fresh After Merge](../tasks/00018-TASK.md) | Published; verify live state | [https://github.com/johnnickell/project-slim/pull/21](https://github.com/johnnickell/project-slim/pull/21) |
<!-- planning:delivery:end -->

## Now

No new human scope decision is recorded. Use the generated TASK routing and delivery sections above, not older
checkpoints below, for current actions. [TASK-00009's post-merge reconciliation](../tasks/00009-TASK.md#post-merge-reconciliation--pr-20)
records its completed delivery and integration. The [delivery contract](../CONVENTIONS.md#current-delivery-handoffs)
prevents ended publication snapshots from requesting another routine cleanup approval.

### Historical TASK-00008 host-boundary closeout

[TASK-00008's OWNER-01 revision](../tasks/00008-TASK.md#current-owner-01-host-boundary-revision--2026-10-25)
is independently accepted and behaviorally QA-passed for C `54e8a995df8c3a4494d70b658c8848d464c87e57`.
This D administrative closeout synchronizes current handoffs; publication and final live verification of existing
[PR #19](https://github.com/johnnickell/project-slim/pull/19) are Land delivery actions recorded in its ignored
receipt and PR body. No new human scope decision is needed. TASK-00009 stays first ready and separately invoked.
TICKET-00011/EPIC-00001 remain open; hosted final integration is outstanding and WF-002 remains paused.

### Historical original TASK-00008 acceptance and publication

[TASK-00008](../tasks/00008-TASK.md#completion-notes) is independently accepted and behavioral-QA passed for
candidate `556adc5`; [PR #19](https://github.com/johnnickell/project-slim/pull/19) is ready for human review and
merge. It retains 30 tests / 98 assertions in one execution with separate suite attribution. No new human scope
decision is required. TASK-00009 is now the first ready implementation successor and needs its own execution
invocation; do not start it as part of TASK-00008 delivery. TICKET-00011/EPIC-00001 remain open for unfinished
gate/HTTP work and required hosted verification. WF-002 remains paused.

### Historical TASK-00007 merge reconciliation

[TASK-00007's merge reconciliation](../tasks/00007-TASK.md#current-merge-reconciliation--2026-10-25) confirms
[PR #18](https://github.com/johnnickell/project-slim/pull/18) merged into `develop` at
`690225d5a6bdb27bb6533fe8c328a3f05f98e031` on 2026-10-25. Its tree matches verified administrative closeout
`f8f82c5`; independent Review/QA remain anchored to accepted candidate `8b7a409`. No TASK-00007 delivery,
merge or new human scope decision remains. TASK-00008 — Align Behavior Suites and Coverage is the first ready
implementation successor; starting it requires its own execution invocation. TICKET-00011/EPIC-00001 remain open,
and WF-002 remains paused. The delivery-pending checkpoints below are history, not current actions.

### Historical TASK-00007 delivery checkpoint

[TASK-00007](../tasks/00007-TASK.md#independent-acceptance-and-delivery-checkpoint) is independently accepted
and QA-passed for candidate `8b7a4092de397d461fa07f910d1ff9d4aab0f3ee`; R-01 is resolved and its historical
revise report is retained. [PR #18](https://github.com/johnnickell/project-slim/pull/18) is the draft delivery PR;
administrative closeout/final-head verification is pending at this checkpoint, so no merge action is yet requested.
TASK-00008 remains the first ready implementation successor, not permission to start it. No new human scope
decision is needed. PR #17 is already integrated at base `b904efd084ed0c7222927f7717b4fb4a9632494a`; its
merge-pending statements below are retained history, not current actions.

### Historical delivery checkpoint before TASK-00007

[PR #16](https://github.com/johnnickell/project-slim/pull/16) merged into `develop` at
`9778ee53aeda451c7993caee81feae72f604aa0b` on 2026-10-24, integrating TASK-00003/00004/00006.
Their independent acceptance and QA PASS at `d62fb30`, fresh PHP 8.5.12 build (26 / 152), focused tests
(12 / 47), compatibility checks and TASK-00017 reconciliation remain historical evidence, not checks of TASK-00002.
No PR #16 merge action remains. TASK-00002 has independent Review acceptance and QA PASS (5/5 scenarios) for
candidate `f2312e78ccc7f9e35068e7d45e488f7bf9ce87df`; [PR #17](https://github.com/johnnickell/project-slim/pull/17)
is its separately authorized `develop` delivery PR. See its [current completion evidence](../tasks/00002-TASK.md#completion-notes).
Human review and merge remain separate; no PR approval, merge, archive, release, or deployment is implied.
Human review and merge of [PR #17](https://github.com/johnnickell/project-slim/pull/17) is the next action for that TASK.

The maintainer selected one-to-one non-domain adoption in [EPIC-00001](../epics/00001-EPIC.md#current-adoption-amendment--2026-10-24).
TASK-00016 is superseded as wontfix: TASK-00008/00009 own the adopted coverage/gate implementation. No policy decision
is still required there. PR #12 is already merged into `develop` at `eec7d06`.
[TASK-00017](../tasks/00017-TASK.md)'s independently accepted and QA-passed PHP 8.5.12 security repair is merged
through [PR #15](https://github.com/johnnickell/project-slim/pull/15) at `922b55f`; neither is a current merge request.

Common 2.0 remains needs-info in TASK-00013. New-only refresh and archive tooling are implemented by TASK-00002;
archive apply/link repair has not been dynamically exercised. No actual archive was requested.

## Active Work

<!-- planning:active:start -->
None.
<!-- planning:active:end -->

## Current Planning Handoff

The approved alignment decomposition is complete; use its existing TASKs. The full AccessControl map remains at
paused WF-002. Revisit frontend/authentication adoption through WF-005/WF-009 once the source flow is complete;
no new EPIC/TICKET/TASK decomposition is currently approved or inferred from this bounded adoption.
TASK selection and blockers belong to the generated sections, not this decomposition handoff. Completed dependency
edges remain history. [TASK-00009](../tasks/00009-TASK.md#post-merge-reconciliation--pr-20) records verified delivery
and integration; its pre-publication checkpoints below are history, not current Land or human-merge requests.

### Historical original TASK-00008 planning handoff

TASK-00008's accepted, QA-passed suite/coverage outcome is published in
[PR #19](https://github.com/johnnickell/project-slim/pull/19) for human review and merge; it unblocks TASK-00009,
and completed dependency edges remain history. TICKET-00011 and EPIC-00001 stay open for their unfinished children;
final hosted gate evidence remains future work.

## Wayfinder Review

[Slim AccessControl Application](../wayfinder/slim-access-control-application-map.md) remains active. Its one current
frontier is [WF-002 — Local Development Runtime Contract](../wayfinder/tickets/WF-002-local-development-runtime-contract.md),
open but paused pending Fight Agent OS direction on shared resources, worktree test isolation, and ingress
integration. Partial decisions are recorded in WF-002; no Wayfinder review candidate is currently available.
This planning pause does not change TASK scopes or the implementation frontier.

## Ready Frontier

Completed edges remain history, not blockers. Readiness never grants execution authority automatically.

<!-- planning:ready:start -->
| Order | Record | Parent | Status | Dependency history | Unfinished blockers | Location |
| --- | --- | --- | --- | --- | --- | --- |
| 10 | [TASK-00010 — Sanitize HTTP Failures](../tasks/00010-TASK.md) | [TICKET-00012](00012-TICKET.md) | ready-for-agent | [TASK-00009](../tasks/00009-TASK.md) | — | live |
<!-- planning:ready:end -->

## Waiting

Unfinished TASK dependencies derive waiting state.

<!-- planning:waiting:start -->
None.
<!-- planning:waiting:end -->

Requirement-level dependencies are not automatically blockers on every child TASK. Completed TASK edges stay in
metadata as history, not unresolved blockers. TASK-00016's scope/coverage decision is resolved; its implementation
belongs to TASK-00008/00009, not a duplicate gate.

## Needs Info

TASK-00013 still needs the Common 2.0 contract, deprecation-removal inventory and migration guide.

<!-- planning:info:start -->
| Order | Record | Parent | Status | Dependency history | Unfinished blockers | Location |
| --- | --- | --- | --- | --- | --- | --- |
| — | [TASK-00013 — Prepare Fight Common 2.0 Migration](../tasks/00013-TASK.md) | [TICKET-00014](00014-TICKET.md) | needs-info | — | — | live |
<!-- planning:info:end -->

## Recently Closed / Done

Completion alone never implies independent acceptance, publication or merge. Each TASK retains its outcome and
delivery evidence; `wontfix` is closure without implementation. The pre-generation outcome inventory below is
preserved as historical narrative, not a second status authority.

<!-- planning:closed:start -->
| Order | Record | Parent | Status | Dependency history | Unfinished blockers | Location |
| --- | --- | --- | --- | --- | --- | --- |
| 1 | [TASK-00001 — Migrate Planning to the New Schema](../tasks/00001-TASK.md) | [TICKET-00007](00007-TICKET.md) | done | — | — | live |
| 1 | [TASK-00017 — Require and Verify the Patched PHP Runtime](../tasks/00017-TASK.md) | Standalone bug | done | — | — | live |
| 2 | [TASK-00002 — Generate Planning Views Safely](../tasks/00002-TASK.md) | [TICKET-00007](00007-TICKET.md) | done | [TASK-00001](../tasks/00001-TASK.md) | — | live |
| 3 | [TASK-00003 — Establish Independent Review Handoffs](../tasks/00003-TASK.md) | [TICKET-00007](00007-TICKET.md) | done | [TASK-00001](../tasks/00001-TASK.md) | — | live |
| 4 | [TASK-00004 — Establish Ownership and PHP Conventions](../tasks/00004-TASK.md) | [TICKET-00008](00008-TICKET.md) | done | [TASK-00001](../tasks/00001-TASK.md) | — | live |
| 5 | [TASK-00005 — Retire Framework Certification](../tasks/00005-TASK.md) | [TICKET-00009](00009-TICKET.md) | done | [TASK-00001](../tasks/00001-TASK.md) | — | live |
| 6 | [TASK-00006 — Qualify Released Dependencies](../tasks/00006-TASK.md) | [TICKET-00010](00010-TICKET.md) | done | [TASK-00005](../tasks/00005-TASK.md) | — | live |
| 7 | [TASK-00007 — Make Development Runtime Worktree-Safe](../tasks/00007-TASK.md) | [TICKET-00011](00011-TICKET.md) | done | [TASK-00001](../tasks/00001-TASK.md) | — | live |
| 8 | [TASK-00008 — Align Behavior Suites and Coverage](../tasks/00008-TASK.md) | [TICKET-00011](00011-TICKET.md) | done | [TASK-00006](../tasks/00006-TASK.md), [TASK-00007](../tasks/00007-TASK.md) | — | live |
| 9 | [TASK-00009 — Deliver the Canonical Quality Gate](../tasks/00009-TASK.md) | [TICKET-00011](00011-TICKET.md) | done | [TASK-00002](../tasks/00002-TASK.md), [TASK-00003](../tasks/00003-TASK.md), [TASK-00004](../tasks/00004-TASK.md), [TASK-00008](../tasks/00008-TASK.md) | — | live |
| — | [TASK-00011 — Establish the Governed Slim Starter Foundation](../tasks/00011-TASK.md) | [TICKET-00013](00013-TICKET.md) | done | — | — | live |
| — | [TASK-00012 — Adopt Fight Common 1.2](../tasks/00012-TASK.md) | [TICKET-00014](00014-TICKET.md) | done | — | — | live |
| — | [TASK-00014 — Re-certify Rewritten Fight Common Candidate](../tasks/00014-TASK.md) | [TICKET-00014](00014-TICKET.md) | done | — | — | live |
| — | [TASK-00015 — Establish the Requirement, Task, and Review Planning Surface](../tasks/00015-TASK.md) | [TICKET-00015](00015-TICKET.md) | wontfix | — | — | live |
| — | [TASK-00016 — Establish the Lean Slim Pre-Submit Quality Gate](../tasks/00016-TASK.md) | [TICKET-00014](00014-TICKET.md) | wontfix | — | — | live |
| — | [TASK-00018 — Keep Delivery Handoffs Fresh After Merge](../tasks/00018-TASK.md) | Standalone bug | done | — | — | live |
<!-- planning:closed:end -->

### Historical outcome inventory before TASK-00002

| TASK | Parent requirement | Outcome |
| --- | --- | --- |
| [TASK-00017 — Require and Verify the Patched PHP Runtime](../tasks/00017-TASK.md) | Standalone bug | done: PHP 8.5.12, runtime rejection and temporary session mitigation; independent acceptance and QA PASS; [PR #15](https://github.com/johnnickell/project-slim/pull/15) merged at 922b55f. |
| [TASK-00003 — Establish Independent Review Handoffs](../tasks/00003-TASK.md) | [TICKET-00007](00007-TICKET.md) | done: shared workflow binding and routing walkthroughs; independent acceptance and QA PASS. |
| [TASK-00004 — Establish Ownership and PHP Conventions](../tasks/00004-TASK.md) | [TICKET-00008](00008-TICKET.md) | done: ADR/standards and sorted callable shared-bus modules; independent acceptance and QA PASS. |
| [TASK-00006 — Qualify Released Dependencies](../tasks/00006-TASK.md) | [TICKET-00010](00010-TICKET.md) | done: Common v1.4.0 / AccessControl v0.8.0 and bounded security patch; independent acceptance and QA PASS. |
| [TASK-00016 — Establish the Lean Slim Pre-Submit Quality Gate](../tasks/00016-TASK.md) | [TICKET-00014](00014-TICKET.md) | wontfix: duplicate gate scope assigned to alignment slices; Agent OS coverage policy adopted, not yet implemented. |
| [TASK-00005 — Retire Framework Certification](../tasks/00005-TASK.md) | [TICKET-00009](00009-TICKET.md) | done: certification files/readers/tests retired; single-lock build passes 26 tests / 152 assertions; review and hosted checks separate. |
| [TASK-00001 — Migrate Planning to the New Schema](../tasks/00001-TASK.md) | [TICKET-00007](00007-TICKET.md) | done: reconciled schema independently accepted at 6203941; preservation checks and canonical build pass; [PR #12](https://github.com/johnnickell/project-slim/pull/12) merged in local develop at eec7d06; no new hosted claim. |
| [TASK-00015 — Establish the Requirement, Task, and Review Planning Surface](../tasks/00015-TASK.md) | [TICKET-00015](00015-TICKET.md) | wontfix: bootstrap-first sequence superseded without implementation; not PR #11's lean-gate handoff. |
| [TASK-00014 — Re-certify Rewritten Fight Common Candidate](../tasks/00014-TASK.md) | [TICKET-00014](00014-TICKET.md) | done: historical tree-equivalent candidate recertification, lock/receipt digests, and canonical build. |
| [TASK-00012 — Adopt Fight Common 1.2](../tasks/00012-TASK.md) | [TICKET-00014](00014-TICKET.md) | done: historical exact candidate/local-safe profile and receipt gates. |
| [TASK-00011 — Establish the Governed Slim Starter Foundation](../tasks/00011-TASK.md) | [TICKET-00013](00013-TICKET.md) | done: historical local/hosted gate receipts and accepted foundation handoff. |
