# Planning Schema Migration — TASK-00001

## Authority and Inventory

The maintainer approved EPIC → TICKET → TASK only and authorized TASK-00001 in the current checkout and branch,
`feature/engineering-alignment-planning`. This mapping was recorded before converting any source path. It is provenance,
not a compatibility table consulted by tools or a second status authority.

The initial Git base was `c44192f3ad3920b3b0383289f71815cb8b028093`. At that intake, eight legacy records coexisted
with seventeen new-schema records (EPIC-00001, TICKET-00007–00012, TASK-00001–00010). There are no archived work records. No IDs or gaps are reused:
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
| T-00006 (uncommitted bootstrap proposal) — `planning/tickets/00006-TICKET.md` | [TASK-00015](tasks/00015-TASK.md) | TICKET-00015 | wontfix |
| T-00006 (lean gate, commit `b8ea885`) — `planning/tickets/00006-TICKET.md` | [TASK-00016](tasks/00016-TASK.md) | TICKET-00014 | ready-for-agent |

EPIC-00002 groups the already-completed starter foundation. EPIC-00003 groups existing Common adoption evidence and
its unresolved 2.0 preparation. These are migration-only containers inferred directly from their sole source
requirements, not newly approved feature programs, deadlines, versions, or completion claims. PRD-00003's explicit
EPIC-00001 parent is preserved. Migrated work is maintenance (`kind: chore`), with empty priority/PR fields: no old
priority or PR URL was recorded, so none is invented.

All eight sources had no `blocked_by` edges. Their new counterparts retain empty edges; the ten alignment TASKs and
six requirements retain their existing dependency graph. Historical bodies may still cite old IDs as provenance;
links resolve to new records. No old ID is a valid checker or archive identity.

## Advanced-Base Reconciliation — 2026-09-28

After independent acceptance of head `7f379366408d84e55dfeb2b00bcb072000930e82`, landing discovered that
`develop` had advanced to `c19e0b9260bccc1cb4b553e2cf41f2e4714385c3` through PR #11. The maintainer reaffirmed
that all records must use the adopted structure and requested reconciliation on the existing branch.

PR #11's commit `b8ea885` adds a **different** T-00006, “Establish the Lean Slim Pre-Submit Quality Gate,” under
PRD-00002. It is not the uncommitted, superseded bootstrap proposal already preserved as TASK-00015 under TICKET-00015.
The old identity/path alone is ambiguous: source revision, title, and parent distinguish these two histories.
Neither is an alias of new TASK-00006 (released dependency qualification).

Before moving the incoming path, this mapping allocated TASK-00016 above the live/archived TASK maximum of 00015.
Its real parent PRD-00002 remains migrated TICKET-00014 under EPIC-00003; no new requirement or implementation split
is invented.
There are now nine legacy source records across the two intakes and 28 destination records (3 EPICs, 9 TICKETs,
16 TASKs). The incoming body and unchecked criteria are preserved exactly. Its source status was ready-for-agent;
current status is deliberately needs-info because its overlapping gate scope and exact 100% direct-Unit coverage
require reconciliation with EPIC-00001/TICKET-00011/TASK-00008/00009, which defer an enforced numeric threshold.
This migration does not select a coverage policy, implement a second gate, or silently declare either plan superseded.

PRD-00002's newer body from `c19e0b9` is retained in TICKET-00014, including its upstream T-00087 handoff. The original
body remains recoverable from the initial snapshot and accepted commit. Board/Roadmap/index references are converted
to the new records; upstream Common IDs remain external provenance. The gate work stays visible as needs-info,
not misclassified as the wontfix bootstrap. No archive occurs.

The incoming diff/source are retained at `.runs/2026-09-28-task-00001-reconcile/`. This substantive reconciliation
requires fresh independent review; the prior accept report remains unchanged and does not certify the new tree.

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
- TASK-00016 preserves the incoming lean-gate body and unchecked criteria; its readiness is held for the explicit
  scope/coverage decision above. TICKET-00014 retains the incoming requirement update, not only the initial snapshot.
- External references to **Fight Common T-00075/T-00087** remain upstream identities, not Slim records or aliases.
- Wayfinder vocabulary changes to EPIC/TICKET/TASK without changing any decision status, dependency, or frontier.

## Disposition and Tooling Boundary

All old live record paths, including the reintroduced T-00006 path, are replaced by the destinations above, not moved
to archives or retained as aliases. The repeated historical path is distinguished by source provenance, never tooling.
The obsolete PRD template/index/directory are removed; active templates cover only the supported hierarchy.
The checker validates that hierarchy and rejects old schemas, including archived work records. It never reads this
mapping to resolve an ID. Archive execution is disabled pending TASK-00002; no archive operation occurs here.

Generated views, `--write`, archive implementation, and review/delivery walkthroughs remain separate TASKs. The Board
and indexes stay manually maintained and truthfully distinguish implementation status from independent acceptance.
Fresh verification and any remaining limitations belong in [TASK-00001](tasks/00001-TASK.md).
