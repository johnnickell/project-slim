# Roadmap

## In progress

TASK-00003/00004/00006 have independent acceptance and QA PASS at `d62fb30`; Land reconciled TASK-00017's accepted
runtime controls with unchanged package entries and application diff. Fresh PHP 8.5.12 build and compatibility
checks pass. One combined PR is authorized; publication and human review/merge are pending.
[TASK-00017](tasks/00017-TASK.md) is merged through [PR #15](https://github.com/johnnickell/project-slim/pull/15)
at `922b55f`. TASK-00002 remains the first ready implementation handoff.

| Epic | Target | Status | Current outcome |
| --- | --- | --- | --- |
| [EPIC-00001](epics/00001-EPIC.md) | Unversioned engineering alignment | in-progress | TASK-00003/00004/00006 independently accepted and QA-passed; combined publication pending. TASK-00002 first ready successor. |
| [EPIC-00003](epics/00003-EPIC.md) | Existing adoption evidence and incoming gate handoff | in-progress | Historical evidence retained. TASK-00013 remains needs-info; TASK-00016 is superseded without a duplicate gate. |

## Route to 1.0

1. Publish TASK-00003/00004/00006's accepted workflow, ownership/composition and released-dependency slices with
   verified reconciliation of TASK-00017, then obtain separate human review/merge. PR #12 is already merged at
   `eec7d06`, not a current merge request. All records use EPIC/TICKET/TASK; [MIGRATION.md](MIGRATION.md) preserves
   provenance. [TASK-00002](tasks/00002-TASK.md) is first ready; generation/archive tooling remains undelivered.
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

[TASK-00017](tasks/00017-TASK.md) requires and executes PHP 8.5.12, rejects stale/unavailable runtimes, preserved
all locked package entries in its repair and passed root HTTP plus 26 tests / 152 assertions. Temporary session-upload
startup mitigation is documented. Independent Review accepted and QA passed;
[PR #15](https://github.com/johnnickell/project-slim/pull/15) is merged. No deployment is claimed.

[EPIC-00002 — Governed Slim Starter Foundation](epics/00002-EPIC.md) groups the historical completed foundation:
[TASK-00011](tasks/00011-TASK.md) retains local/hosted build receipts, not fresh verification of this change.

[TICKET-00015](tickets/00015-TICKET.md) / [TASK-00015](tasks/00015-TASK.md) are wontfix: the bootstrap-first sequence was
superseded before implementation, not completed or released. PR #11's different lean-gate handoff remains visible
in TASK-00016, now separately superseded by the explicit 2026-10-24 scope/coverage decision, not conflated with that
history. TASK-00003/00004/00006 have independent acceptance and QA PASS; delivery remains separate.
Generated views/`--write` and archive execution remain unavailable
pending TASK-00002. No release is claimed.
