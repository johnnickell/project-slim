---
id: TICKET-00009
epic: EPIC-00001
title: Single-Lock Development Without Framework Certification
status: ready-for-agent
order: 3
blocked_by:
---

# Single-Lock Development Without Framework Certification

## Problem and Outcome

Slim's gate certifies a development package candidate across dependency lanes and no-dev installation. The maintainer
explicitly retired that ongoing support claim. The application must use one authoritative lock without maintaining
replacement certification machinery.

## Included Use Cases

- Install and verify the application from its committed `composer.lock` and ordinary development dependencies.
- Remove lowest/latest lane execution, the lowest lock/digest, no-dev certification, package-source cloning used only
  for certification, and receipt generation/verification machinery retained solely for the retired profile.
- Classify existing tests by observable application/integration value versus certification-only assertions. Remove
  obsolete certification checks while preserving meaningful booted behavior evidence and ordinary setup.
- Supersede operative matrix/receipt obligations in documentation and gate wiring without rewriting the successful
  historical outcomes of TASK-00012/TASK-00014 (former T-00002/T-00005) or pretending their old receipts verify the new gate.

No business commands, queries, events, permissions, or product state changes apply. Validation concerns the selected
application dependency graph and retained behavior; security includes preserving secret/configuration rejection tests.

## Exclusions

Substitute lowest/latest or no-dev proof, fresh certification receipts, dependency-version upgrades, product-feature
changes, full gate modernization, deleting useful tests merely because they touch a package, and implicit archiving.

## Dependencies and Sequencing

No requirement blocker. This removes candidate-specific certification constraints before TICKET-00010 qualifies
releases. Complete runtime/gate modernization and suite/coverage organization belong to TICKET-00011. Keep each
intermediate gate coherent rather than partially referencing removed files.

## Acceptance Criteria

- [ ] **AC-01:** Only the application lock remains authoritative; the lowest lock/digest and dependency-lane execution
  are removed, with no replacement matrix or ongoing no-dev obligation.
- [ ] **AC-02:** Gate paths no longer generate/verify support receipts, clone upstream source solely for certification,
  or install a separate no-dev graph. Every deleted mechanism has its live callers and obsolete documentation removed.
- [ ] **AC-03:** Existing tests have an explicit disposition: meaningful application/integration behavior is retained,
  certification-only checks are retired, and no replacement product tests of quality tooling are introduced.
- [ ] **AC-04:** Operative support claims describe one application lock. Historical TASK-00012/TASK-00014 outcomes remain
  addressable and clearly historical; removed artifact paths are not presented as active verification commands.
- [ ] **AC-05:** Ordinary setup and the remaining canonical gate work locally and in hosted CI without changing the
  selected dependency versions or intended application behavior.

## Verification

Inspect live references after retirement, verify the main lock and package versions did not change, run retained
behavior/integration tests and `./bin/build`, and obtain hosted evidence for the changed gate. Report test removals
and their rationale, not a misleading comparison of raw test counts. Do not require replacement matrix evidence.

## Implementation Handoff

[TASK-00005 — Retire Framework Certification](../tasks/00005-TASK.md) covers AC-01 through AC-05, spanning gate
callers, certification files, obsolete tests, and operative docs. It is blocked by TASK-00001.

## Progress

Retirement and the TASK split are approved as an intentional narrowing of ongoing compatibility claims. TASK-00005
is authored but not implemented; no certification machinery has been removed.
