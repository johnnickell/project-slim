---
id: TICKET-00007
epic: EPIC-00001
title: Consistent Planning and Independent Review
status: in-progress
order: 1
blocked_by:
---

# Consistent Planning and Independent Review

## Problem and Outcome

Contributors need distinct requirements, implementation, review, and publication authority with one supported
planning schema: `EPIC -> TICKET -> TASK`. The maintainer explicitly rejected dual-schema compatibility. Migrate old
records with traceable provenance rather than retain a second parser, execution frontier, or archive mode.

[TICKET-00015](00015-TICKET.md) and [TASK-00015](../tasks/00015-TASK.md) preserve former PRD-00003/T-00006 as superseded,
unimplemented history. Their bootstrap-first restriction is not operative. See the [provenance mapping](../MIGRATION.md);
no historical completion is implied by converting their record types.

## Included Use Cases

- Author EPIC destinations, requirement TICKETs, and separately approved bounded TASKs. Document standalone bug/chore
  exceptions without inventing requirements. Requirement acceptance is not implementation authority.
- Migrate existing PRD requirements and executable T-tickets into their correct roles, with collision-safe new IDs,
  explicit old-to-new provenance, preserved acceptance/status/dependency meaning, and repaired references. Old IDs
  become provenance, not alternate supported identities. Preserve the unresolved Common 2.0 information gate.
- Validate only the new work hierarchy and find executable TASKs through record-owned status/priority and generated
  views. Keep ADR and Wayfinder decision roles distinct without interpreting them as implementation records.
- Refresh generated sections explicitly and detect drift through a read-only check. Preserve authored strategy,
  historical evidence, and open product decisions without parallel mutable status authorities.
- Hand exact implementation snapshots to independent Spec and Standards review before separately authorized
  publication. Disclose involvement, findings, verification limits, and accept/revise; an author cannot independently
  accept their own implementation.
- Supply new-schema archive eligibility, dry-run-first behavior, link repair, and explicit apply authority, without
  performing archives during migration or preserving obsolete PRD/executable T-ticket command modes.

No business commands, queries, events, permissions, or product state changes apply. Validation concerns record
integrity; security concerns secret-safe evidence, reviewer authority, and checkout/resource ownership.

## Exclusions

Dual-schema parsing, legacy executable frontiers, identity aliases accepted by tooling, legacy archive modes,
runtime/dependency changes, build-phase replacement, certification retirement, product implementation, shared/global
skill changes, actual archive operations, publication, merge, release, and deployment.

## Dependencies and Sequencing

No requirement blocker. Requirements and TASKs may be written before automation exists. TASK-00001 migrates the records
and replaces the validator with new-only support; TASK-00002 implements projections and new-schema archive tooling;
TASK-00003 supplies detailed review/delivery guidance. New-only validation is implemented; generated views and archive
execution remain unavailable. A passing planning check does not waive the full build or independent review.

## Acceptance Criteria

- [ ] **AC-01:** Conventions, templates, and entrypoints define only the new work hierarchy, parentage, standalone
  exceptions, lifecycle, priority, and completion versus review/publication authority. No operative PRD/T-ticket
  authoring or execution path remains after migration.
- [x] **AC-02:** The checker validates EPIC/TICKET/TASK records and rejects legacy work-record schemas without fallback.
  Validate parent kinds, links, unique identities/path collisions, statuses, required metadata, same-kind dependency
  edges, and cycles; preserve completed edges and derive unfinished blockers.
- [ ] **AC-03:** Explicit refresh is deterministic and limited to generated sections; default validation is read-only
  and rejects drift. Execution views contain TASKs only, including any appropriately migrated unresolved work.
- [ ] **AC-04:** An explicit provenance mapping accounts for the old portfolio and its migrated meaning/status/evidence;
  links are repaired without requiring old live paths. New-schema archives enforce terminal-child eligibility and
  link repair without legacy modes or implicit archive operations.
- [ ] **AC-05:** Independent review handoffs identify requirements, base/head, branch, relevant dirty-state evidence,
  reviewer relationship, separate Spec/Standards conclusions, fresh checks, findings, and limitations. Missing,
  stale, or non-independent acceptance cannot authorize publication; review never authorizes merge.
- [ ] **AC-06:** Entry instructions and Wayfinder handoff references agree on the new-only model without silently
  closing product decisions. Normal and stale/missing-review walkthroughs preserve execution and publication authority.

## Verification

Compare migration source and destination records against the provenance mapping; inspect links, status, dependency
meaning, and historical acceptance evidence. Validate the actual migrated portfolio, run explicit generation twice
once implemented, and prove read-only checks. Inspect refusal and archive paths directly; do not seed invalid fixtures
or add product tests of planning tools. Run the operative canonical gate; do not perform an unrequested archive or
claim unexercised behavior was dynamically verified.

## Implementation Handoff

The approved slices now target only the new schema:

| TASK | Parent criteria covered | Blockers |
| --- | --- | --- |
| [TASK-00001 — Migrate Planning to the New Schema](../tasks/00001-TASK.md) | AC-02; schema/routing portion of AC-01; migration/provenance portion of AC-04 | — |
| [TASK-00002 — Generate Planning Views Safely](../tasks/00002-TASK.md) | AC-03; archive portion of AC-04; planning routing portions of AC-01/AC-06 | TASK-00001 |
| [TASK-00003 — Establish Independent Review Handoffs](../tasks/00003-TASK.md) | AC-05; delivery/walkthrough portions of AC-01/AC-06 | TASK-00001 |

## Progress

Requirement and TASK split approved, with the subsequent human decision replacing legacy compatibility with a
one-time migration and new-only tooling. TASK-00001's initial migration and F-01 correction were independently
accepted at `7f37936`. PR #11's additional legacy gate record is now TASK-00016 under the same new-only model.
Both historical T-00006 sources are distinguished; gate scope/coverage remains an explicit needs-info decision,
not a migration policy choice. Reconciliation is locally verified by preservation checks and the canonical build,
and independently accepted at `6203941` against `c19e0b9` with no findings.
[PR #12](https://github.com/johnnickell/project-slim/pull/12) publishes the accepted work with metadata-only landing
updates; hosted checks and human approval/merge remain separate.
AC-02 is covered; AC-01/04 have migration portions delivered but still need their downstream guidance/archive work.
Generated views, archive implementation, and detailed review handoffs remain TASK-00002/00003 work, so this requirement
is not done. TASK-00002 is the first ready successor; completed dependency edges remain history.
