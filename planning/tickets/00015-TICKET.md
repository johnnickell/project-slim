---
id: TICKET-00015
epic: EPIC-00001
title: Planning and Review Transition for Engineering Alignment
status: wontfix
order:
blocked_by:
---

# Planning and Review Transition for Engineering Alignment

## Migration Provenance

Converted from PRD-00003; see the [mapping](../MIGRATION.md). Child [TASK-00015](../tasks/00015-TASK.md), formerly
T-00006, is also wontfix. No approval or execution is transferred. Everything below is the superseded proposal,
including its obsolete identity/compatibility/sequence rules: it is not operative guidance. Current conventions
support only EPIC/TICKET/TASK. Status and unchecked historical criteria are unchanged.

## Historical Proposal Body (Nonoperative)

## Supersession

Closed without implementation. The maintainer approved authoring requirement TICKETs and TASKs under an explicit
transitional convention rather than waiting for a bootstrap migration. [TICKET-00007](00007-TICKET.md)
owns the continuing planning/review requirements. [T-00006](../tasks/00015-TASK.md) is likewise superseded.
The remaining text preserves the original proposal; its bootstrap-first restriction is no longer operative.
No implementation, successful verification, or migration completion is claimed.

## Problem Statement

The approved engineering alignment needs requirement TICKETs and implementation TASKs, but Slim currently uses
PRDs for requirements and T-tickets for executable work. Writing new-style TICKETs immediately would give the same
record type two incompatible meanings and leave the existing validator, Board, and archive command behind.

## Solution

Bootstrap the transition through one explicitly legacy executable ticket, then resume requirement decomposition
under the implemented conventions. The human maintainer approved the six requirement areas in
[EPIC-00001](../epics/00001-EPIC.md#approved-requirement-decomposition) and this bootstrap-first sequence.

Contributors must be able to:

- distinguish an epic destination, requirement TICKET, and bounded implementation TASK;
- find executable work from record-owned status, priority, and unfinished dependencies;
- retrieve old records by their existing identities and links without reinterpreting their historical meaning;
- refresh generated views explicitly and detect stale or invalid planning without a build rewriting documents;
- hand an exact implementation snapshot to independent Spec and Standards review before publication; and
- distinguish verified implementation completion from review, publication, merge, archive, release, and deployment.

## Implementation Decisions

- [T-00006](../tasks/00015-TASK.md) is a current-convention executable bootstrap ticket, not a new-style
  requirement TICKET or an implicitly renamed TASK. No TASK is created by this planning operation.
- Implement the new conventions, templates, planning validation/generation, archive compatibility, and routing
  guidance together. Keep the existing seven status values and derive blocking from unfinished dependency edges.
- New requirements use `TICKET-NNNNN` with an epic parent; new implementation records use `TASK-NNNNN` with a
  requirement parent, except explicitly documented standalone bugs/chores. Preserve sequences and gaps, and allocate
  paths without colliding with legacy records, including archived ones.
- Keep existing PRD and T-ticket identities, paths, outcomes, and links as legacy records. Do not silently relabel
  executable work as requirements or manufacture replacement records. Document the compatibility mapping once.
- Give every outstanding legacy execution record one explicit place in the new frontier. In particular, preserve
  T-00003 as `needs-info`; the transition does not supply Fight Common 2.0 migration authority. T-00006 remains the
  addressable owner of its own eventual completion evidence.
- Store execution priority and status in records. Generate Board/index/status projections while preserving authored
  strategy and decision prose. Preserve completed dependency edges rather than erasing history.
- Make `./bin/planning-check --write` the explicit view refresh and the default invocation read-only. The current
  checker does not implement refresh; this is a future deliverable, not a command whose output proves it exists now.
- Preserve explicit-only archive authority and dry-run-first behavior for both legacy and new records. Implement
  compatibility without moving or archiving any planning record during this transition.
- Define a Slim-owned independent review handoff naming the requirement, base/head, branch, dirty-state evidence
  where applicable, reviewer relationship, Spec and Standards findings, fresh verification, and accept/revise result.
  Implementation authors cannot independently accept their work. Review does not authorize publication or merge.
- Reconcile instruction entrypoints and the existing Wayfinder handoff language with the new hierarchy without
  changing open product decisions or claiming those investigations are complete.

## Testing Decisions

- Validate planning and tooling directly with the owning commands and inspection; do not add product-suite tests of
  Markdown, wrappers, planning, review instructions, or seeded invalid quality-tool fixtures.
- Use the real portfolio to prove identity/link preservation, unchanged historical outcomes, visible unfinished
  work, deterministic refresh, and a clean read-only check after generation.
- Review the validator's refusal paths for duplicate or colliding identities, wrong or missing parents, missing
  links, dependency cycles, and stale generated views. Report any unverified behavior instead of fabricating proof.
- Walk a normal implementation-to-independent-review handoff and an unavailable or stale review handoff from the
  written instructions. The latter must not grant publication, approval, or merge authority.
- Run the currently operative canonical `./bin/build` before completion. This bootstrap does not remove dependency
  certification phases; that belongs to the separately approved requirement area.

## Out of Scope

- Creating the six new-style requirement records before the planning transition works, or decomposing TASKs as part
  of this bootstrap's implementation.
- Changing runtime behavior, Composer dependencies, the build's verification phases, coverage, or HTTP responses.
- Implementing product features, new business commands/queries/events, authentication, or permissions. There is no
  product state transition here; validation concerns planning integrity and authority, not transport input.
- Archiving records, copying private planning or source identities, changing shared/global skills, publishing a PR,
  merging, releasing, or deploying.

## Further Notes

This PRD covers the bootstrap portion of approved requirement area 1, not the implementation of the full alignment
epic. After T-00006 is complete, resume the approved six-area decomposition using the new schema. Record bootstrap
work as already delivered evidence rather than inventing another implementation of it.

Tickets: [T-00006 — Establish the Requirement, Task, and Review Planning Surface](../tasks/00015-TASK.md).
