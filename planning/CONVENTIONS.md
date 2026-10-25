# Planning Conventions

## Lightweight work routing

For “What's next?”, `next`, or an unqualified `/ask-matt`, use the routing entry in root AGENTS.md.
This read-only path precedes general orientation; full implementation, review, QA and delivery requirements
still apply when the selected workflow is invoked.

1. Run `./bin/planning-check --check-delivery` once before selection or recommending a publication/merge handoff.
   It validates local views and checks only explicitly marked current delivery snapshots. OPEN retains its
   handoff (draft means Land prerequisites, not human merge). A verified MERGED, already-done and locally
   integrated handoff resolves read-only: continue selection without another routine cleanup request even
   while its marker remains. Report the live observation, not an older publication checkpoint. Failure or
   unavailable evidence stops selection with the actual identity and missing fact/owner; never infer merge
   or refresh views. An offline `./bin/planning-check` pass is not live delivery freshness. Without a validator,
   disclose that limitation and cross-check selected metadata against the authored Board.
2. Read only the Board's current human decision, active work, and (if no active work) first ready entry.
   Use local section names and authoritative order. Return all active TASKs, not a new winner. Inspect selected
   TASK metadata and its current handoff, plus blocker metadata only as needed. An unresolved contradiction
   is a named input gap, not permission to audit every record or infer acceptance from `done`.
3. Read the Wayfinder index's map-status/frontier inventory. Closed or decision-complete maps need no historical
   reread. For active/open maps, read only current frontier and decision/dependency status or explicit external
   prerequisite evidence needed for availability. Unknown state or an absent frontier needs its owner's input.
   Multiple available maps remain independent choices; no global priority is implied.
4. Use the Board/Roadmap's current planning handoff for unfinished decomposition, including closed maps.
   Verify the named phase in the owning record's current progress/approval section. Map closure, parent status
   and child counts do not prove complete decomposition. If the handoff is missing or contradictory, report
   the missing phase/owner; do not reconstruct it by reading every closed map and descendant.
5. Read canonical review/QA identity and disposition only when they change the selected route. Unresolved
   identity is an evidence handoff, never acceptance. Confirm a suggested skill from supplied capability
   metadata/bindings; load its full instructions and references when invoked, not merely to recommend it.

Prefer heading searches and bounded section reads. Aim to retrieve no more than about 24,000 characters
of routing evidence; stop with a precise unresolved input before exceeding that scope unless the user requests
a deeper audit. Do not read append-only task histories, other worktrees' entire tasks, general architecture,
or all receiving skills to produce a recommendation. Return TASK, WAYFINDER, and relevant PLANNING/HUMAN INPUT;
stop without invoking a workflow or changing files. Missing indexes are reported, not fabricated.

During authorized planning updates, keep current planning/decomposition handoffs source-linked and concise:
phase, target and decision owner. Current TASK selection belongs in the generated Board `next` and Roadmap
`execution` blocks, not duplicated mutable selection prose. TASKs own stage/evidence, and the generated Board
`delivery` block mirrors explicit publication snapshots. Keep Wayfinder inventory/frontier pointers current.
Preserve historical decisions in their owning records; checkpoints are not live publication or merge claims.

Routing sources: [TASK Board](tickets/BOARD.md), [Wayfinder inventory](wayfinder/README.md), [Roadmap](ROADMAP.md).

## One Supported Schema

Slim supports `EPIC -> TICKET -> TASK` only:

- EPIC: destination, business outcome, and boundaries.
- TICKET: related use cases and requirements, not executable work or normally one PR.
- TASK: bounded, independently reviewable implementation, normally one PR.

Decompose an approved epic into requirements, then obtain approval of the implementation split before writing TASKs.
Neither planning operation starts implementation. Requirement and TASK authoring does not wait for planning automation.

The maintainer explicitly rejected dual-schema support. [TASK-00001](tasks/00001-TASK.md) converted the old PRDs and
executable T-tickets with the [source-to-destination provenance mapping](MIGRATION.md). Old IDs are historical prose,
not valid record identities, execution paths, or parser aliases. Preserve meaning and evidence without retaining a
second mutable hierarchy. Existing references now resolve to new records; no archive operation occurred.

[TICKET-00015](tickets/00015-TICKET.md) and [TASK-00015](tasks/00015-TASK.md) preserve the superseded bootstrap-first
proposal as wontfix history, not operative guidance or implemented work.

**Delivered tooling:** `./bin/planning-check` validates the new hierarchy, local Markdown file targets and marked
view freshness without writing. It derives unfinished TASK blockers without deleting historical edges. Explicit
`./bin/planning-check --write` validates the portfolio and marker structure before completing eligible parents and
refreshing projections; a second refresh changes nothing. Heading anchors are not validated. Unsupported arguments
fail explicitly. New-only archive tooling has separate explicit-request/dry-run/apply rules below. TASK-00002
performs no archives; archive apply/link repair is implemented but dynamically unexercised. Direct checks do not
replace `./bin/build`, and no failing required gate permits a commit/publication.

## Automatic parent completion

When a TASK becomes `done` or `wontfix`, complete eligible parent TICKETs and then EPICs in the same operation.
Count live and archived children. A live, non-terminal parent with at least one child closes when every child
is terminal: use `wontfix` if every child is `wontfix`, otherwise `done`. Parents without children or with an
unfinished child remain open. Preserve already-terminal and archived parents.

Child acceptance and intentional `wontfix` decisions remain with the child records. Parent completion requires
no separate assessment, independent review, QA, confirmation, or skill invocation. Record any remaining work as
an unfinished child rather than a separate parent-closeout gate. Parent status does not assert review, merge,
release, deployment or publication, and completion never archives records automatically.

The completing agent updates parent metadata and affected indexes, Board and Roadmap in this same action.
Run explicit `./bin/planning-check --write` to complete eligible parents and refresh views, then read-only
`./bin/planning-check` to verify freshness. This does not inspect or supply independent review/QA/hosted proof;
leave a child unfinished until its required acceptance evidence exists.


## Directory Structure

```
planning/
  adr/              Architecture Decision Records
  agents/           Focused working instructions
  epics/            EPIC destinations
  tickets/          Requirement TICKETs
  tasks/            Implementation TASKs
  wayfinder/        Investigation maps and WF decision records
  ROADMAP.md        Strategic progress
  README.md         Directory guide
  CONVENTIONS.md    This file
```

`MIGRATION.md` preserves provenance for the removed PRD layer and old T-ticket paths; tooling never reads it as an
identity resolver. ADRs and Wayfinder decisions retain distinct roles and are not implementation records.

## File Naming and Metadata

| Artifact | Filename | Displayed ID |
| --- | --- | --- |
| Epic | `NNNNN-EPIC.md` | `EPIC-NNNNN` |
| Requirement | `NNNNN-TICKET.md` | `TICKET-NNNNN` |
| Implementation | `NNNNN-TASK.md` | `TASK-NNNNN` |
| ADR | `NNNN-short-description.md` | ADR number |
| Wayfinder map | `descriptive-name-map.md` | Map name |
| Wayfinder decision | `WF-NNN-description.md` | `WF-NNN` |
| Wayfinder research | `WF-NNN-description-research.md` | Related WF decision |

Each record kind has its own five-digit sequence. Inspect live and archived identities, historical allocations,
and occupied paths before allocation; preserve gaps and never reuse an identity. Allocate above the existing maximum,
not into old gaps. TICKETs 00001–00006 remain reserved historical filename slots. TASK-00006 is dependency qualification;
the uncommitted bootstrap T-00006 migrated to TASK-00015, while PR #11's distinct lean-gate T-00006 migrated to
TASK-00016. Their source revisions/titles/parents distinguish historical provenance; neither is an identity alias.
Work records live directly in their kind's directory or its `archive/` subdirectory; duplicate IDs across live/archive
and case-insensitive path collisions are invalid.

Keep copy-ready `_…_TEMPLATE.md` files beside records. Templates are not records and receive no ID. Use the appropriate
template when authoring a record; never change a template to store a live decision.

- EPICs require `id`, `title`, `status`, and `target`, list their TICKETs, and record progress.
- TICKETs require `id`, `epic`, `title`, `status`, `order`, and `blocked_by`; the parent is an EPIC.
- TASKs require `id`, `ticket`, `kind`, `title`, `status`, `order`, `blocked_by`, and `pr`. The parent is a TICKET, except
  standalone `bug` or `chore` TASKs may have an empty parent with an explicit rationale. Kinds are `feature`, `bug`,
  and `chore`. A parentless bug/chore additionally requires nonempty `standalone_reason` metadata; omit that field
  for parented work. A feature must always have a requirement parent.

Frontmatter uses flat, unquoted, single-line scalar fields (including empty values), not general YAML lists, aliases,
quoted/block scalars, or inline comments. Duplicate and unknown fields are invalid. Empty `order`, `blocked_by`, and
`pr` fields are permitted, but their keys are required where listed. EPIC `target` is a nonempty destination/version
statement, not a release assertion. Nonempty `pr` must be an HTTP(S) URL.

### Current delivery handoffs

A live TASK may carry optional `delivery: awaiting-merge` and its verified GitHub `pr` URL. Land records this
publication snapshot for the matching OPEN PR, not a perpetual claim that it remains open. An empty delivery
field is allowed; nonempty delivery is invalid on archived records or other record kinds. Neither `done`, a PR
URL nor historical prose creates a live handoff. The generated Board delivery block says "Published; verify live
state"; only a fresh live observation establishes the remaining action.

`./bin/planning-check --check-delivery` is read-only. It uses existing operator `gh` access for at most 16 marked
PRs, one 15-second metadata request each, and bounded local Git calls. Repository/origin, URL, number, exact
TASK/title, TASK feature branch, develop base and full published head OID must agree. OPEN preserves its handoff;
OPEN/draft retains Land prerequisites rather than requesting human merge. MERGED resolves without blocking
selection or requiring another cleanup approval only with valid merge time/OID, already-`done` status and local
published-head→merge→HEAD ancestry proof. Local inspection disables replacement objects and lazy fetching; the
checker never fetches or integrates Git objects. Merge/integration facts do not infer independent acceptance or QA.

At authorized Work, Land or substantive planning intake on the selected feature branch, run
`./bin/planning-check --reconcile-delivery` before record edits. This project-owned administrative operation is
included in those scopes, not a new routine cleanup request. It performs the same live verification, removes
only verified merged/integrated done markers, appends exact observation/head/merge/time/local-ancestry evidence
to each owning TASK, and refreshes views and eligible parents. OPEN remains unchanged. Repeated use is
idempotent; retired and unmarked historical PRs are never queried. Routing, Review and QA never run writing modes.

CLOSED WITHOUT MERGE requires a disposition decision. A merged non-terminal TASK requires scope recovery; absent
local ancestry requires authorized integration. Missing CLI/authentication, API/network failures, malformed or
contradictory metadata, wrong identity and invalid local views stop with the precise prerequisite. Validation or
live-evidence failure prevents all planned writes, including refreshing stale views. Actual write/I/O failure
requires inspecting disk before retry; this is not a filesystem transaction. No failure infers merge or acceptance.

All three modes (`--write`, `--check-delivery`, `--reconcile-delivery`) are mutually exclusive. Default checks and
`--write` remain offline; `./bin/build` stays read-only and network-independent for planning. These commands do not
check hosted CI, publish, approve, merge, release, archive or change acceptance. Land separately preserves required
hosted delivery proof and runs live checks before publication and after final metadata changes under the
[workflow binding](../docs/engineering/WORKFLOWS.md#delivery-pre-submit-and-final-handoff).

Optional priority `order` is a positive integer, lower first; unranked records come last and IDs break ties.
Requirement blockers refer to requirements; TASK blockers refer to TASKs. Use comma-separated, whitespace-trimmed IDs
and an empty field for none. Requirement-level final acceptance dependencies are not automatically blockers on every
child TASK. Optional `pr` records a URL, not proof of publication or merge.

## Lifecycle

| Status | Meaning |
| --- | --- |
| `needs-triage` | Scope or ownership is unclassified |
| `needs-info` | A decision or required evidence is missing |
| `ready-for-agent` | Requirements may be decomposed; TASKs may be implemented when dependencies and execution authority permit |
| `ready-for-human` | Human judgment or external action is next |
| `in-progress` | Implementation or revision is underway |
| `done` | Acceptance and required verification are complete |
| `wontfix` | Intentionally closed without implementation |

Blocking is derived from unfinished `blocked_by` edges, not a stored status. Preserve completed edges as history.
Requirement approval is not requirement completion. A TICKET becomes done only when its accepted outcomes and child
implementation evidence are complete. TASK done does not assert independent review, publication, merge, archive,
release, or deployment; record those states and evidence separately.

## Board and Views

Record metadata owns status, priority and dependencies. `planning/tickets/BOARD.md` is the sole TASK execution view;
its Active Work, Ready Frontier, Waiting, Needs Info and terminal projections are generated. Requirements are not
executable rows. Migrated information/terminal work uses its new TASK identity; no alternate legacy frontier remains.
All active TASKs are returned before selecting the first ready TASK by positive `order`, unranked last, ID tie-break.

The generated Board `next` summary and Roadmap `execution` summary share the same TASK grouping/order as the
full Board: all active TASKs, otherwise the first ready TASK, with info/human items and first waiting reason when
no TASK is executable. The Board `delivery` summary selects only explicit delivery markers. Offline validation
rejects drift in these summaries, not just full status tables. Generated selection never grants execution authority.

The Board shows:

- **"What's Next?" Contract**: return the current human decision when one remains and the first executable TASK;
- **Now**: the current decision or execution prerequisite requiring human input;
- **Ready Frontier**: ordered TASKs with no unfinished TASK blockers;
- **Waiting**: ready TASKs whose dependency edges are unfinished;
- **Needs Info**: unresolved decisions/evidence; and
- **Recently Closed / Done**: terminal outcomes, distinguishing closure without implementation from completion.

`./bin/planning-check --write` explicitly validates and refreshes `<!-- planning:NAME:start -->` / `end` sections;
the default invocation is read-only and rejects stale views or eligible uncompleted parents. Missing, duplicated or
reversed marker pairs fail before writes; preserve the pairs supplied by EPIC/TICKET templates when authoring records.
Indexes include live/archived inventory and separate dependency history from unfinished blockers. Parent records
project children, including archived children. Archived TASKs do not appear in the execution frontier.
Builds must never refresh planning implicitly. Keep authored strategy, genuine human decisions, decomposition
handoffs and Wayfinder pointers outside generated sections. Keep historical delivery evidence in owning records,
clearly scoped to its checkpoint. Do not duplicate current TASK selection or live merge claims in authored routing
prose; the checker cannot establish arbitrary narrative truth from metadata.

`planning/ROADMAP.md` retains **In progress**, **Route to <version>**, and **Completed / Released** sections.
Its marked status projections derive from records; authored strategy remains editable.

## Wayfinder

Wayfinder is planning-only investigation for work too uncertain to decompose. A map is an index, not a second store
of decisions; each material decision belongs in one linked WF ticket. Research captures evidence, not implementation
authority. The implementation handoff is EPIC, requirement TICKETs, then separately approved TASKs. Schema migration
changed handoff terminology only; it did not close any Wayfinder decision.

Use the local map template, in this order:

1. `Label: wayfinder:map` and explicit Active/Closed status;
2. destination and precise done condition;
3. scoped notes and linked decision summaries;
4. linked decision table with type, mode, status, and dependencies;
5. nontrivial blocking relationships; and
6. one explicit Frontier, remaining fog, and out-of-scope boundaries.

`planning/wayfinder/README.md` remains the continuity index. The Board may name one Wayfinder Review candidate only
when an active map has a concrete unblocked frontier suitable for review. Link the map and frontier decision; do not
invent a candidate when none exists. This pointer never overrides the TASK frontier or the map's decision authority.

## Archive: Explicit Requests Only

Archive only on an explicit request. Use the owning command, inspect its dry run, and use `--apply` only after the
proposed moves are correct. Schema migration is not an archive request; do not move records into archives as a
completion side effect or use a legacy archive mode as a workaround.

The archive command supports only the selectors below. Default invocation is a read-only dry run: it validates
records, links, fresh projections and eligibility, then prints moves, rewritten files and a plan digest. Inspect
that plan before repeating the same selection with `--apply --confirm DIGEST`. Both flags are required together;
a changed input/plan invalidates the digest. The flags express explicit apply authority, not permission inferred
from terminal status. Use `--help` for syntax. Unsupported, duplicate, wrong-kind, unknown, archived or nonterminal
selectors fail closed (exit 2); destination collisions and symlinks also refuse. No PRD/T-ticket aliases exist.

| Request | Target command shape | Destination |
| --- | --- | --- |
| archive TASKs | `./bin/archive-planning tasks TASK-NNNNN … [--apply --confirm DIGEST]` | `planning/tasks/archive/` |
| archive TICKETs | `./bin/archive-planning tickets TICKET-NNNNN … [--apply --confirm DIGEST]` | `planning/tickets/archive/` |
| archive EPICs | `./bin/archive-planning epics EPIC-NNNNN … [--apply --confirm DIGEST]` | `planning/epics/archive/` |
| archive a Wayfinder map | `./bin/archive-planning wayfinder name-map [--apply --confirm DIGEST]` | Existing Wayfinder archive locations |

TASKs must be terminal. TICKETs additionally require all child TASKs terminal; EPICs require all child TICKETs terminal.
A Wayfinder map is separately governed: select its exact basename without `.md`; it must have `**Status:** Closed`,
all linked decision tickets Closed with nonempty Resolution sections, an explicit `None`, `None.` or `—` Frontier,
and a `## Resolution` linking its EPIC/TICKET/TASK implementation handoff. Shared decisions referenced by another live
map refuse rather than moving shared authority. The map moves to `wayfinder/archive/`, its linked decisions to
`archive/tickets/`, and directly linked research to `archive/research/`. No Wayfinder state is inferred or closed.
Preserve records, identities and evidence; the tool repairs repository-owned inline Markdown links (including moved
sources' relative targets), preserves query/fragment suffixes and refreshes projections. Plain prose/code-span
historical paths and heading-anchor validity are not rewritten/validated. Prospective validation runs before apply;
apply rechecks source bytes, validates the result and attempts rollback on I/O/validation failure. It is not a
crash-atomic transaction or backup: inspect the working tree after any interrupted/failed apply.
After an authorized archive, run read-only planning validation, inspect repaired links, and commit the move and
reference repair together. Historical artifacts are not an excuse to retain multiple live planning schemas.

## Branches, Review, and Pre-PR Synchronization

Use `feature/<description>` from `develop`; never commit directly to `develop` or `main`. Confirm the implementation
checkout/worktree with the human, preserve unrelated work, and keep scratch under ignored `.runs/` rather than planning.

Before final commit or PR:

1. Record the TASK's verified acceptance and outstanding limitations; mark done only when required evidence is complete.
2. Reflect the implementation outcome in the Board and recompute the execution frontier.
3. Update parent TICKET and EPIC progress, without marking a requirement done solely because its text was accepted.
4. Update Roadmap strategy/projections if the milestone changed.
5. Refresh generated views explicitly when supported, then run read-only planning validation.
6. Check that completed blockers are no longer treated as unresolved, while preserving dependency edges as history.
7. Refresh Wayfinder continuity when its frontier or handoff changes.
8. Run the full canonical `./bin/build`; focused checks do not replace it. Do not commit/publish with a failing gate.

Independent review challenges requirements (Spec) and local engineering/delivery rules (Standards), discloses reviewer
involvement, and identifies the exact reviewed snapshot and evidence. The [shared workflow binding](../docs/engineering/WORKFLOWS.md)
adopts canonical report, QA, reconciliation and delivery protocols with Slim substitutions, including explicit marked-view
refresh and read-only drift validation. A material contributor cannot independently accept their implementation; review does
not grant publication or merge authority. Keep explicitly required hosted evidence and current acceptance separate
from implementation completion. Use shared ignored evidence paths without moving historical runs.
