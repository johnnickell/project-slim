# Roadmap

## In progress

| Epic | Target | Status | Current outcome |
| --- | --- | --- | --- |
| [EPIC-00001](epics/00001-EPIC.md) | Unversioned engineering alignment | in-progress | TASK-00001 independently accepted; [PR #12](https://github.com/johnnickell/project-slim/pull/12) open, human merge separate. TASK-00002 first ready successor. |
| [EPIC-00003](epics/00003-EPIC.md) | Existing adoption evidence and incoming gate handoff | in-progress | Historical adoption/receipt evidence retained. Common 2.0 remains needs-info in TASK-00013; migrated lean-gate TASK-00016 needs a scope/coverage decision. |

## Route to 1.0

1. Review [TASK-00001](tasks/00001-TASK.md)'s published [PR #12](https://github.com/johnnickell/project-slim/pull/12)
   and hosted checks before a separate human merge decision. All records use EPIC/TICKET/TASK;
   [MIGRATION.md](MIGRATION.md) distinguishes the two historical T-00006 sources. TASK-00002 is the first ready
   successor; generated views/archive tooling and review handoffs remain separate work.
2. Resolve [TASK-00016](tasks/00016-TASK.md)'s incoming lean-gate handoff against the alignment slices before gate/
   coverage implementation: assign its overlapping scope and decide exact 100% direct-Unit coverage versus the
   deferred-threshold policy. Preserve the upstream handoff without silently choosing either policy or building two gates.
3. Transition to the accepted architecture, HTTP, testing, gate, planning, and review model.
   [TASK-00005](tasks/00005-TASK.md) has retired framework certification, its readers and tests; the single-lock
   build passes. Continue the remaining alignment without restoring that machinery.
4. Qualify a stable released dependency baseline through separately authorized work, without assuming another
   consumer's versions are compatible.
5. Revisit 2.0 only after Fight Common publishes its migration authority. This roadmap does not authorize a release.

## Completed / Released

[EPIC-00002 — Governed Slim Starter Foundation](epics/00002-EPIC.md) groups the historical completed foundation:
[TASK-00011](tasks/00011-TASK.md) retains local/hosted build receipts, not fresh verification of this change.

[TICKET-00015](tickets/00015-TICKET.md) / [TASK-00015](tasks/00015-TASK.md) are wontfix: the bootstrap-first sequence was
superseded before implementation, not completed or released. PR #11's different lean-gate handoff remains visible
in TASK-00016, not conflated with that history. Generated views/`--write` and archive execution remain unavailable
pending TASK-00002. No release is claimed.
