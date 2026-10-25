# Roadmap

## In progress

[TASK-00009's accepted canonical gate](tasks/00009-TASK.md#current-acceptance-and-delivery-checkpoint--2026-10-25)
uses read-only host planning before running-service PHP quality phases and one attributed PHPUnit execution.
Implementation A `a96c9795e511ad166764dba647c56035d8b06007` has independent Review acceptance, independent QA PASS (5/5),
and required hosted evidence in [Build run 40165446430](https://github.com/johnnickell/project-slim/actions/runs/40165446430).
Owner-approved metadata-only B closes TASK-00009/TICKET-00011; fresh hosted delivery CI for B remains required before
PR #20 is ready. EPIC-00001 remains open; TASK-00010 is now ready by record status but is not started under this
Land-only scope. The [Board](tickets/BOARD.md) owns routing; WF-002 stays paused. TASK-00008 PR #19 is integrated at the implementation
base, not awaiting delivery.

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

1. Continue from integrated PR #16's workflow, ownership/composition and released-dependency slices, with verified
   TASK-00017 reconciliation. PR #12 is also merged at `eec7d06`. All records use EPIC/TICKET/TASK;
   [MIGRATION.md](MIGRATION.md) preserves provenance. [TASK-00002](tasks/00002-TASK.md) supplies explicit generation,
   read-only drift checks and new-only archive tooling; it performs no archives. Independent Review accepted and QA
   passed for the PR's acceptance candidate; human review/merge remain separate.
2. Continue the suite/gate slices after TASK-00007's bounded runtime implementation under the
   [adoption amendment](epics/00001-EPIC.md#current-adoption-amendment--2026-10-24).
   TASK-00016 is wontfix as a duplicate path; Agent OS's all-suite Domain/Application line coverage with separate
   suite attribution and visible Adapter gaps is implemented by TASK-00008's shared single-run test command;
   absent business layers are N/A. TASK-00009 implements the expanded gate locally; required hosted integration
   remains unverified and prevents its completion.
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
EPIC-00001's required hosted completion proof remains outstanding.
