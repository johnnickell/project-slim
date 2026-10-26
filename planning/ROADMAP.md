# Roadmap

## In progress

Use the [current Board merge observation](tickets/BOARD.md#now): PR #19/#21 are verified merged/integrated;
publication-pending text below remains historical and creates no recurring merge/reconciliation request.

The [Board](tickets/BOARD.md) owns execution routing; this generated summary shares its record-owned selection.
Delivery snapshots require the bounded live check under [the delivery contract](CONVENTIONS.md#current-delivery-handoffs).
The [current planning handoff](tickets/BOARD.md#current-planning-handoff) owns decomposition, not this execution view.

<!-- planning:execution:start -->
| Route | TASK | Status | Unfinished blockers |
| --- | --- | --- | --- |
| Needs Info / Human Action | [TASK-00013 — Prepare Fight Common 2.0 Migration](tasks/00013-TASK.md) | needs-info | — |
| Ready Frontier | [TASK-00010 — Sanitize HTTP Failures](tasks/00010-TASK.md) | ready-for-agent | — |
<!-- planning:execution:end -->

[TASK-00009's canonical gate](tasks/00009-TASK.md#post-merge-reconciliation--pr-20) is integrated through PR #20.
Accepted A retains its independent Review/QA and hosted proof; metadata-only B passed final delivery CI before
human merge. The gate's read-only host planning, running-service PHP phases and single attributed PHPUnit run
are delivered. Future product scope remains separate; WF-002's external prerequisite is unchanged.

### Historical TASK-00008 host-boundary closeout

[TASK-00008's OWNER-01 host-boundary revision](tasks/00008-TASK.md#current-owner-01-host-boundary-revision--2026-10-25)
is independently accepted and behaviorally QA-passed for C `54e8a995df8c3a4494d70b658c8848d464c87e57`, without
replacing the gate or duplicating tests. This D administrative closeout synchronizes current handoffs; Land records
PR #19 publication and final live verification in its ignored receipt and PR body. TASK-00009 remains separately
invoked and first ready; no successor work starts here. TICKET-00011/EPIC-00001 stay open for unfinished gate/HTTP
work and required hosted integration. WF-002 remains paused; the [TASK Board](tickets/BOARD.md) owns routing.

### Historical original TASK-00008 acceptance and publication

[TASK-00008's behavior-suite and coverage implementation](tasks/00008-TASK.md#completion-notes) is independently
accepted and behavioral-QA passed for candidate `556adc5`; [PR #19](https://github.com/johnnickell/project-slim/pull/19)
is ready for human review and merge. It records 30 tests / 98 assertions in one execution, separate
Unit/Integration/Functional attribution, Domain/Application N/A, and visible Adapter Unit gaps. TASK-00009 is first
ready for the expanded gate and required hosted integration, followed by TASK-00010. TICKET-00011/EPIC-00001 remain
open for unfinished children; no eligible parent closeout is deferred. WF-002 remains paused. The
[TASK Board](tickets/BOARD.md) owns execution routing; no new scope or TASK-00009 execution is authorized by this
completion.

### Historical TASK-00007 merge reconciliation

[TASK-00007's merge reconciliation](tasks/00007-TASK.md#current-merge-reconciliation--2026-10-25) confirms
[PR #18](https://github.com/johnnickell/project-slim/pull/18) merged into `develop` at
`690225d5a6bdb27bb6533fe8c328a3f05f98e031` on 2026-10-25. Its tree matches verified administrative closeout
`f8f82c5`, preserving independent Review/QA acceptance of candidate `8b7a409` without implementation changes.
No runtime delivery/merge action remains; TASK-00008 is first ready, followed by TASK-00009/00010. Coverage,
the expanded gate and required final hosted integration remain outstanding, so TICKET-00011/EPIC-00001 stay open.
WF-002 remains paused. The [TASK Board](tickets/BOARD.md) owns execution routing; the checkpoints below are historical.

### Historical TASK-00007 delivery checkpoint

[TASK-00007](tasks/00007-TASK.md#independent-acceptance-and-delivery-checkpoint) has independent Review
acceptance and QA PASS for candidate `8b7a4092de397d461fa07f910d1ff9d4aab0f3ee`; Review R-01's ambient orphan
deletion is resolved and its historical revise report is preserved. [PR #18](https://github.com/johnnickell/project-slim/pull/18)
is the draft delivery PR; administrative closeout/final-head verification is pending at this checkpoint, not a merge
claim. TASK-00008 remains first ready, followed by TASK-00009/00010; the full gate/coverage and required hosted
integration are not claimed complete. TICKET-00011/EPIC-00001 remain open. PR #17 is integrated at base
`b904efd084ed0c7222927f7717b4fb4a9632494a`; its older delivery checkpoint below is historical.

### Historical delivery checkpoint before TASK-00007

TASK-00003/00004/00006 have independent acceptance and QA PASS at `d62fb30`; Land reconciled TASK-00017's accepted
runtime controls with unchanged package entries and application diff. Their fresh PHP 8.5.12 build and compatibility
checks passed. Combined [PR #16](https://github.com/johnnickell/project-slim/pull/16) merged at
`9778ee53aeda451c7993caee81feae72f604aa0b` on 2026-10-24; no merge request remains.
[TASK-00017](tasks/00017-TASK.md) is merged through [PR #15](https://github.com/johnnickell/project-slim/pull/15)
at `922b55f`. TASK-00002's independent acceptance and QA PASS apply to
`f2312e78ccc7f9e35068e7d45e488f7bf9ce87df`; [PR #17](https://github.com/johnnickell/project-slim/pull/17)
is open for human review and merge. The [TASK Board](tickets/BOARD.md) owns the current execution frontier.

<!-- planning:active-epics:start -->
| Epic | Target | Status | Location |
| --- | --- | --- | --- |
| [EPIC-00001 — Align Engineering and Delivery](epics/00001-EPIC.md) | unversioned | in-progress | live |
| [EPIC-00003 — Fight Common Adoption Continuity](epics/00003-EPIC.md) | Existing adoption evidence; Common 2.0 authority unresolved | in-progress | live |
<!-- planning:active-epics:end -->

## Route to 1.0

1. Build on the integrated workflow, ownership/composition, dependency and planning slices. All records use
   EPIC/TICKET/TASK; [MIGRATION.md](MIGRATION.md) preserves provenance. [TASK-00002](tasks/00002-TASK.md) supplies
   explicit generation, read-only drift checks and new-only archive tooling; it performs no archives.
2. Continue the suite/gate slices after TASK-00007's bounded runtime implementation under the
   [adoption amendment](epics/00001-EPIC.md#current-adoption-amendment--2026-10-24).
   TASK-00016 is wontfix as a duplicate path; Agent OS's all-suite Domain/Application line coverage with separate
   suite attribution and visible Adapter gaps is implemented by TASK-00008's shared single-run test command;
   absent business layers are N/A. [TASK-00009](tasks/00009-TASK.md#post-merge-reconciliation--pr-20) records the
   expanded gate's verified local/hosted acceptance, final delivery and integration.
3. Transition to the accepted architecture, HTTP, testing, gate, planning, and review model.
   [TASK-00005](tasks/00005-TASK.md) has retired framework certification, its readers and tests; the single-lock
   build passes. Continue the remaining alignment without restoring that machinery.
4. Retain the qualified Common v1.4.0 / AccessControl v0.8.0 lock and explicit maintenance. TASK-00010 will integrate
   released safe HTTP middleware with actual Slim/parser/header regressions; installing it is not activation.
   Revisit the completed source frontend/login flow and applicable tests through WF-005/WF-009; no unfinished flow
   or Agent OS domain is adopted. WF-002's shared-resource/ingress decision remains paused.
5. Revisit 2.0 only after Fight Common publishes its migration authority. This roadmap does not authorize a release.

## Completed / Released

Status projections are not release assertions. Refresh explicitly with `./bin/planning-check --write`;
`./bin/planning-check` and the build check without writing.

<!-- planning:closed-epics:start -->
| Epic | Target | Status | Location |
| --- | --- | --- | --- |
| [EPIC-00002 — Governed Slim Starter Foundation](epics/00002-EPIC.md) | Historical foundation; no release target | done | live |
<!-- planning:closed-epics:end -->

[TASK-00017](tasks/00017-TASK.md) requires and executes PHP 8.5.12, rejects stale/unavailable runtimes, preserved
all locked package entries in its repair and passed root HTTP plus 26 tests / 152 assertions. Temporary session-upload
startup mitigation is documented. Independent Review accepted and QA passed;
[PR #15](https://github.com/johnnickell/project-slim/pull/15) is merged. No deployment is claimed.

[EPIC-00002 — Governed Slim Starter Foundation](epics/00002-EPIC.md) groups the historical completed foundation:
[TASK-00011](tasks/00011-TASK.md) retains local/hosted build receipts, not fresh verification of this change.

[TICKET-00015](tickets/00015-TICKET.md) / [TASK-00015](tasks/00015-TASK.md) are wontfix: the bootstrap-first sequence was
superseded before implementation, not completed or released. PR #11's different lean-gate handoff remains visible
in TASK-00016, now separately superseded by the explicit 2026-10-24 scope/coverage decision, not conflated with that
history. TASK-00003/00004/00006 have independent acceptance and QA PASS and are integrated through PR #16.
Archive apply/link repair is implemented but dynamically unexercised in TASK-00002; no archive or release is claimed.
TASK-00009's required hosted gate proof is recorded in its owning TASK. Remaining epic work is not implied complete.
