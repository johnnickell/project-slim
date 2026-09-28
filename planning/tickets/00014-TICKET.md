---
id: TICKET-00014
epic: EPIC-00003
title: Fight Common Version Adoption and Support Evidence
status: in-progress
order:
blocked_by:
---

# Fight Common Version Adoption and Support Evidence

## Migration Provenance and Current Boundary

Converted from PRD-00002 under [TASK-00001](../tasks/00001-TASK.md); see the [mapping](../MIGRATION.md).
EPIC-00003 is a migration-only grouping, not a new program or release commitment. Status remains in-progress because
Common 2.0 preparation and the incoming lean-gate scope decision remain unresolved, not because ongoing certification
is newly authorized.

Children: [TASK-00012](../tasks/00012-TASK.md) (historical adoption), [TASK-00014](../tasks/00014-TASK.md) (historical
recertification), [TASK-00013](../tasks/00013-TASK.md) (needs-info; no Common 2.0 implementation authority), and
[TASK-00016](../tasks/00016-TASK.md) (PR #11's lean-gate handoff; needs-info for scope/coverage reconciliation).
The T-00006 in the incoming source body means TASK-00016, not TASK-00015's superseded bootstrap proposal.
[EPIC-00001](../epics/00001-EPIC.md) supersedes the historical ongoing matrix/receipt obligations below. Retirement is
TASK-00005 work; reconcile the overlapping TASK-00016 handoff before implementing gate/coverage changes. The source
body from `c19e0b9` is retained below, including the newer upstream T-00087 handoff. It is not fresh gate evidence.
The exact-coverage requirement conflicts with the alignment plan's deferred threshold; migration chooses neither.

## Historical Requirement Body

## Problem Statement

The starter must prove its Fight Common support claim through its own Composer graph and booted Slim composition.

## Solution

Adopt the pinned compatible candidate through Composer and commit `evidence/framework-support/receipt-v1.json`; keep
2.0 non-executable until its owning authority exists.

## Implementation Decisions

- The lockfile, candidate identity, selected capabilities, and booted journeys are adoption evidence.
- Slim owns explicit registrars and container configuration; Fight Common remains a Composer dependency only.
- No speculative 2.0 breaking changes are defined here.

## Testing Decisions

- Lowest/latest resolutions, booted journeys, receipt canonicalization, `./bin/planning-check`, and `./bin/build` prove a receipt.

## Out of Scope

- Copied source, nested applications, central builds, releases, and publication.

## Further Notes

The 2026-09-09 authorship-only Fight Common rewrite changed the certified candidate identity without changing its
tree. T-00005 records the exact mapping, regenerated consumer evidence, and replacement certification while
preserving the original ticket's historical statements.

Tickets: T-00002, T-00003, T-00005, T-00006. T-00002 and T-00005 remain historical adoption and recertification
records. Fight Common T-00087 transfers the lean pre-submit quality-gate implementation to T-00006, which removes
receipt/profile/lane fixtures and monolithic certification topology while retaining direct Unit coverage and useful
Slim-native boundaries. T-00003 remains the sole 2.0 planning item. Receipt schema authority: Fight Common T-00075.
