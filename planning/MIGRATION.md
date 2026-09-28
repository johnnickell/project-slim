# Planning Schema Migration — TASK-00001

## Authority and Inventory

The maintainer approved EPIC → TICKET → TASK only and authorized TASK-00001 in the current checkout and branch,
`feature/engineering-alignment-planning`. This mapping was recorded before converting any source path. It is provenance,
not a compatibility table consulted by tools or a second status authority.

The starting Git base is `c44192f3ad3920b3b0383289f71815cb8b028093`. Eight legacy records coexist with seventeen new-schema
records (EPIC-00001, TICKET-00007–00012, TASK-00001–00010). There are no archived work records. No IDs or gaps are reused:
new requirement IDs begin at 00013, TASKs at 00011, and EPICs at 00002. Original PRDs lacked parents except PRD-00003.

The pre-existing, approved but uncommitted planning is included in the migration scope, not discarded. A byte-preserving
local snapshot of all planning, AGENTS.md, and original tooling is at `.runs/2026-09-27-task-00001/backup/`; the tracked
diff, untracked inventory, and status are beside it. That ignored recovery copy is not a supported portfolio or archive.
Committed migrated records retain the source narrative/evidence even where the original was never committed.

## Source-to-Destination Mapping

Statuses here describe migration inputs only. Current status belongs to each destination record.

| Source ID and path | Destination | Parent after migration | Input status |
| --- | --- | --- | --- |
| PRD-00001 — `planning/specs/00001-PRD.md` | [TICKET-00013](tickets/00013-TICKET.md) | [EPIC-00002](epics/00002-EPIC.md) | done |
| PRD-00002 — `planning/specs/00002-PRD.md` | [TICKET-00014](tickets/00014-TICKET.md) | [EPIC-00003](epics/00003-EPIC.md) | in-progress |
| PRD-00003 — `planning/specs/00003-PRD.md` | [TICKET-00015](tickets/00015-TICKET.md) | [EPIC-00001](epics/00001-EPIC.md) | wontfix |
| T-00001 — `planning/tickets/00001-TICKET.md` | [TASK-00011](tasks/00011-TASK.md) | TICKET-00013 | done |
| T-00002 — `planning/tickets/00002-TICKET.md` | [TASK-00012](tasks/00012-TASK.md) | TICKET-00014 | done |
| T-00003 — `planning/tickets/00003-TICKET.md` | [TASK-00013](tasks/00013-TASK.md) | TICKET-00014 | needs-info |
| T-00005 — `planning/tickets/00005-TICKET.md` | [TASK-00014](tasks/00014-TASK.md) | TICKET-00014 | done |
| T-00006 — `planning/tickets/00006-TICKET.md` | [TASK-00015](tasks/00015-TASK.md) | TICKET-00015 | wontfix |

EPIC-00002 groups the already-completed starter foundation. EPIC-00003 groups existing Common adoption evidence and
its unresolved 2.0 preparation. These are migration-only containers inferred directly from their sole source
requirements, not newly approved feature programs, deadlines, versions, or completion claims. PRD-00003's explicit
EPIC-00001 parent is preserved. Migrated work is maintenance (`kind: chore`), with empty priority/PR fields: no old
priority or PR URL was recorded, so none is invented.

All eight sources had no `blocked_by` edges. Their new counterparts retain empty edges; the ten alignment TASKs and
six requirements retain their existing dependency graph. Historical bodies may still cite old IDs as provenance;
links resolve to new records. No old ID is a valid checker or archive identity.

## Semantic Preservation

- TICKET-00013/TASK-00011 retain historical foundation acceptance, not a fresh claim about today's build.
- TICKET-00014/TASK-00012/TASK-00014 retain exact candidate identities and historical receipt evidence. Ongoing
  certification obligations were superseded by EPIC-00001; their runtime removal belongs to TASK-00005, not this move.
- TASK-00013 remains `needs-info`: the owning Common 2.0 contract, deprecation-removal inventory, and migration guide
  must exist before bounded execution is planned. This conversion supplies none of that authority.
- TICKET-00015/TASK-00015 remain `wontfix`, with all unchecked criteria and superseded proposal text retained as
  explicitly nonoperative history. Their old dual-schema/bootstrapping proposal never became implemented behavior.
- Historical body prose is retained, with relative Markdown targets repaired where files moved. New provenance
  notices separate source claims from current evidence; no acceptance checkboxes in migrated bodies are changed.
- The external reference to **Fight Common T-00075** remains an upstream identity, not a Slim record or alias.
- Wayfinder vocabulary changes to EPIC/TICKET/TASK without changing any decision status, dependency, or frontier.

## Disposition and Tooling Boundary

The eight old live record paths are replaced by the destinations above, not moved to archives or retained as aliases.
The obsolete PRD template/index/directory are removed; active templates cover only the supported hierarchy.
The checker validates that hierarchy and rejects old schemas, including archived work records. It never reads this
mapping to resolve an ID. Archive execution is disabled pending TASK-00002; no archive operation occurs here.

Generated views, `--write`, archive implementation, and review/delivery walkthroughs remain separate TASKs. The Board
and indexes stay manually maintained and truthfully distinguish implementation status from independent acceptance.
Fresh verification and any remaining limitations belong in [TASK-00001](tasks/00001-TASK.md).
