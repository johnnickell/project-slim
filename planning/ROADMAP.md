# Roadmap

## In progress

| Epic | Target | Status | Current outcome |
| --- | --- | --- | --- |
| [EPIC-00001](epics/00001-EPIC.md) | Unversioned engineering alignment | in-progress | TASK-00001 locally complete: new-only migration/validation, provenance, disabled archives. Independent review pending; TASK-00002 first ready successor. |
| [EPIC-00003](epics/00003-EPIC.md) | Existing adoption evidence; Common 2.0 authority unresolved | in-progress | Historical candidate adoption/receipt evidence preserved; ongoing certification superseded by EPIC-00001. TASK-00013 remains needs-info. |

## Route to 1.0

1. Independently review [TASK-00001 — Migrate Planning to the New Schema](tasks/00001-TASK.md), locally verified in
   the authorized current checkout/branch. Migration preserves historical evidence through [MIGRATION.md](MIGRATION.md),
   not a compatibility parser. TASK-00002 is the first ready successor; generated views/archive tooling and review
   handoffs remain separately authorized work.
2. Transition to the accepted architecture, HTTP, testing, gate, planning, and review model. Retire the dependency
   matrix and no-dev certification without substituting equivalent certification requirements; preserve historical
   outcomes and meaningful behavior evidence.
3. Qualify a stable released dependency baseline through separately authorized work, without assuming another
   consumer's versions are compatible.
4. Revisit 2.0 only after Fight Common publishes its migration authority. This roadmap does not authorize a release.

## Completed / Released

[EPIC-00002 — Governed Slim Starter Foundation](epics/00002-EPIC.md) groups the historical completed foundation:
[TASK-00011](tasks/00011-TASK.md) retains local/hosted build receipts, not fresh verification of this change.

[TICKET-00015](tickets/00015-TICKET.md) / [TASK-00015](tasks/00015-TASK.md) are wontfix: the bootstrap-first sequence was
superseded before implementation, not completed or released. New-only schema validation is implemented; generated
views/`--write` and archive execution remain unavailable pending TASK-00002. No release is claimed.
