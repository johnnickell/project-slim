# Roadmap

## In progress

| Epic | Target | Status | Current outcome |
| --- | --- | --- | --- |
| [EPIC-00001](epics/00001-EPIC.md) | Unversioned engineering alignment | in-progress | TASK-00003/00004/00006 locally complete; independent review/QA pending. TASK-00002 first ready successor. |
| [EPIC-00003](epics/00003-EPIC.md) | Existing adoption evidence and incoming gate handoff | in-progress | Historical evidence retained. TASK-00013 remains needs-info; TASK-00016 is superseded without a duplicate gate. |

## Route to 1.0

1. Independently review TASK-00003/00004/00006's completed workflow, ownership/composition and released-dependency
   slices; satisfy applicable QA before separately authorized publication. PR #12 is already merged locally at
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

[EPIC-00002 — Governed Slim Starter Foundation](epics/00002-EPIC.md) groups the historical completed foundation:
[TASK-00011](tasks/00011-TASK.md) retains local/hosted build receipts, not fresh verification of this change.

[TICKET-00015](tickets/00015-TICKET.md) / [TASK-00015](tasks/00015-TASK.md) are wontfix: the bootstrap-first sequence was
superseded before implementation, not completed or released. PR #11's different lean-gate handoff remains visible
in TASK-00016, now separately superseded by the explicit 2026-10-24 scope/coverage decision, not conflated with that
history. TASK-00003/00004/00006 have local implementation evidence, not independent acceptance or publication.
Generated views/`--write` and archive execution remain unavailable
pending TASK-00002. No release is claimed.
