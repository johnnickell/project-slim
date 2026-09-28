---
id: TICKET-00010
epic: EPIC-00001
title: Qualified Released Dependency Baseline
status: ready-for-agent
order: 4
blocked_by: TICKET-00009
---

# Qualified Released Dependency Baseline

## Problem and Outcome

The committed and installed Fight packages are development candidates. Neither a version alias nor another
consumer's lock proves Slim's release compatibility. Select installable public releases deliberately and prove the
existing consumer contract using one lock.

## Included Use Cases

- Inspect actual public release artifacts, constraints, and exact capability signatures before selecting versions.
- Run dependency installation, updates, and audits as explicit maintenance operations, with a reviewed lock diff and
  package identity evidence rather than as canonical build phases.
- Update consumer composition only where an existing integration requires it and the compatibility impact is bounded.
- Record future integration constraints, especially package handlers requiring `UnitOfWork` versus a concrete adapter
  implementing only `TransactionalUnitOfWork`. Do not claim that naming a container alias solves a PHP type mismatch.
- Reconcile release qualification with WF-001's released-package inventory gate without claiming this bounded current
  integration check completes its full capability audit.

No new business commands, queries, events, permissions, or persistence journeys are introduced. Validation is package
compatibility; security concerns trusted public artifacts, dependency advisories, and secret-free evidence.

## Exclusions

Blindly copying another consumer's versions, a Common 2.0 migration, package-source changes/publication, development
aliases presented as releases, a second dependency lane, and implementing future AccessControl persistence or handlers.

## Dependencies and Sequencing

Depends on TICKET-00009 removing candidate-specific certification constraints. Qualification may inspect release
availability earlier, but final acceptance uses the single-lock model. If no compatible public release exists,
record the exact blocker and stop rather than substituting a development branch or broadening scope silently.
TICKET-00011 and TICKET-00012 use the selected lock for their final evidence.

## Acceptance Criteria

- [ ] **AC-01:** Selected Fight package versions resolve to actual public releases, with explicit constraints and a
  reviewed single application lock. Evidence distinguishes manifest intent, locked identity, and installed identity.
- [ ] **AC-02:** Relevant public signatures and dependency constraints are checked against current composition/callers;
  changes preserve existing behavior or explicitly document approved compatibility consequences.
- [ ] **AC-03:** Normal installation and retained application/integration tests pass against the selected release graph;
  no matrix/no-dev certification or support receipt is reintroduced.
- [ ] **AC-04:** Maintenance commands and advisory findings are documented separately from build verification; unavailable
  artifacts, unresolved advisories, and uncertain compatibility are reported rather than silently waived.
- [ ] **AC-05:** Future handler/persistence incompatibilities and WF-001 follow-up are explicit. Neither this record nor
  a green current application gate asserts acceptance of unimplemented package use cases.

## Verification

Use repository Composer wrappers for explicit maintenance, inspect the resulting public installation and lock diff,
run focused retained integration contracts and the operative `./bin/build`, and record warnings and unresolved findings.
No version update or external availability claim is made by this requirement document.

## Implementation Handoff

[TASK-00006 — Qualify Released Dependencies](../tasks/00006-TASK.md) covers AC-01 through AC-05 and is blocked by
TASK-00005. Establish actual release availability/signatures before changing constraints; stop for a scope decision
if a compatible baseline requires new product behavior. This TASK is not the superseded bootstrap proposal in TASK-00015 (formerly T-00006).

## Progress

Requirement and TASK split approved; TASK-00006 is authored but not implemented. Exact versions are not inferred
from the earlier comparison. No release availability, qualification, or dependency update is claimed.
