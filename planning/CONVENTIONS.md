# Planning Conventions

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

**Delivered tooling:** `./bin/planning-check` validates only the new hierarchy and local Markdown file targets,
read-only. It derives unfinished TASK blockers without deleting historical edges. It does not generate views or
validate heading anchors. Unsupported arguments, including `--write`, fail explicitly. TASK-00002 owns generation,
read-only drift checks, and new-schema archive tooling; archive execution is disabled until then. Direct checks do
not replace `./bin/build`, and no failing required gate permits a commit/publication.

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

Record metadata owns status, priority, and dependencies. During the tooling transition,
`planning/tickets/BOARD.md` remains the manually maintained execution entrypoint for TASKs only. Requirements are not
executable rows. Migrated information/terminal work uses its new TASK identity; no alternate legacy frontier remains.
TASK-00002 establishes generated views and updates entrypoint references atomically.

The Board shows:

- **"What's Next?" Contract**: return the current human decision when one remains and the first executable TASK;
- **Now**: the current decision or execution prerequisite requiring human input;
- **Ready Frontier**: ordered TASKs with no unfinished TASK blockers;
- **Waiting**: ready TASKs whose dependency edges are unfinished;
- **Needs Info**: unresolved decisions/evidence; and
- **Recently Closed / Done**: terminal outcomes, distinguishing closure without implementation from completion.

Maintain indexes and Board projections manually until generation is implemented. Afterwards,
`./bin/planning-check --write` explicitly validates and refreshes marked sections, and the default invocation is
read-only and rejects stale views. Builds must never refresh planning implicitly. Preserve authored strategy and
material decisions outside generated sections.

`planning/ROADMAP.md` retains **In progress**, **Route to <version>**, and **Completed / Released** sections.
Its status projections derive from records once generation is implemented; authored strategy remains editable.

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

The current archive command is deliberately disabled: every invocation exits 2 without mutation, including help,
Wayfinder selection, and apply requests. The legacy implementation was removed rather than kept as a bypass.
TASK-00002 implements new-schema archive tooling. The target commands below are requirements, not current support:

| Request | Target command shape | Destination |
| --- | --- | --- |
| archive TASKs | `./bin/archive-planning tasks TASK-NNNNN … [--apply]` | `planning/tasks/archive/` |
| archive TICKETs | `./bin/archive-planning tickets TICKET-NNNNN … [--apply]` | `planning/tickets/archive/` |
| archive EPICs | `./bin/archive-planning epics EPIC-NNNNN … [--apply]` | `planning/epics/archive/` |
| archive a Wayfinder map | `./bin/archive-planning wayfinder map-name [--apply]` | Existing Wayfinder archive locations |

TASKs must be terminal. TICKETs additionally require all child TASKs terminal; EPICs require all child TICKETs terminal.
A Wayfinder map must be Closed, all linked decisions Closed, frontier empty, and resolution linked to its implementation
handoff. Preserve records, identities, and evidence; repair links and refresh projections using the owning tool.
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
involvement, and identifies the exact reviewed snapshot and evidence. Detailed guidance is TASK-00003 work. A material
contributor cannot independently accept their implementation; review does not grant publication or merge authority.
