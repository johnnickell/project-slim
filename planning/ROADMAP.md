# Roadmap

## In progress

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
2. Implement remaining runtime/suite/gate slices under the [adoption amendment](epics/00001-EPIC.md#current-adoption-amendment--2026-10-24).
   TASK-00016 is wontfix as a duplicate path; Agent OS's all-suite Domain/Application line coverage with separate
   suite attribution and visible Adapter gaps is the accepted policy. Do not claim it is enforced yet.
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
