---
id: TICKET-00011
epic: EPIC-00001
title: Reproducible Runtime and One Quality Gate
status: ready-for-agent
order: 5
blocked_by: TICKET-00007, TICKET-00008, TICKET-00009, TICKET-00010
---

# Reproducible Runtime and One Quality Gate

## Problem and Outcome

Developers and hosted CI need one predictable, noninteractive verification path instead of rebuilding a disposable
image and mixing dependency maintenance with tests. Meaningful behavior evidence and unit coverage must be visible
without manufacturing tests of infrastructure or rerunning product suites.

## Included Use Cases

- Explicitly prepare dependencies and start the local Compose runtime; use repository lifecycle/exec/test wrappers
  with documented missing-service behavior, safe defaults, and isolated concurrent worktrees.
- Execute `./bin/build` through a thin wrapper and a PHP phase orchestrator inside the already-running service.
  Run named, fail-fast planning, syntax, qualified Fight PHPCS, PHPStan, Deptrac, Rector dry-run, and PHPUnit phases.
- Run every configured product suite exactly once in one coherent PHPUnit/coverage execution. Read coverage from
  that execution rather than rerunning tests; distinguish owned unit coverage from integration/functional coverage.
- Select tests that prove owned behavior and important package integrations. Validate wiring, generated artifacts,
  architecture, wrappers, quality tooling, and test infrastructure directly using their owning tools.
- Run the same canonical command in hosted CI after explicit setup, and surface failures, warnings, skipped tests,
  unavailable drivers, coverage denominators, and justified exclusions honestly.

No business commands, queries, events, permissions, or product-state transitions are added. Security concerns local
binding, secrets, checkout/resource isolation, and safe diagnostics. Validation concerns source and behavior evidence.

## Exclusions

Future full application topology/services, frontend tooling, deployment, dependency installation/update/audit inside
the gate, certification matrices/no-dev checks, an arbitrary numeric coverage gate, tests of quality tools, and
placeholder production code or routes created only to satisfy static analysis or coverage.

## Dependencies and Sequencing

Final acceptance depends on TICKET-00007's working planning validation, TICKET-00008's rules, TICKET-00009's retirement,
and TICKET-00010's selected released lock. Child TASKs should use only their true blockers: runtime isolation can be
implemented before all final gate prerequisites exist. Reconcile wrapper decisions with WF-002 without implementing
or closing its full future runtime investigation.

## Acceptance Criteria

- [ ] **AC-01:** Runtime setup, lifecycle, test, and exec commands are documented and verified on a clean checkout and
  concurrently isolated worktrees, with no fixed-port/resource collisions or cleanup of unrelated resources.
- [ ] **AC-02:** `./bin/build` uses the running service and a PHP orchestrator with the named fail-fast phases. Missing
  prerequisites fail clearly; no per-build image rebuild, dependency maintenance, or new Python gate orchestration
  is introduced. Existing planning validation may remain Python.
- [ ] **AC-03:** PHPCS, PHPStan, Deptrac, and Rector are configured for actual owned code and accepted rules without
  speculative source, unexplained suppression, or claims that static tools prove semantic ownership.
- [ ] **AC-04:** Product suites prove meaningful success/rejection/failure and integration effects. Tooling/configuration
  tests are removed or replaced by direct checks where needed; certification-only checks stay retired. Test
  dispositions preserve important application protections rather than optimize counts.
- [ ] **AC-05:** Each configured suite runs exactly once; separate unit coverage states denominator, driver, exclusions,
  and gaps. Coverage remains a completeness aid, not protocol or security proof; no numeric threshold is implied.
- [ ] **AC-06:** Hosted CI explicitly prepares and starts the environment, then invokes the same canonical command with
  fresh passing evidence on the released lock. Local results, warnings, and hosted limitations are distinguished.

## Verification

Use direct wrapper execution and source/tool inspection, clean-checkout setup, concurrent runtime evidence, named
quality phases, and one coherent suite report. Do not add product tests of wrappers, tool configurations, generated
files, or deliberately invalid fixtures. Final acceptance requires actual hosted results; unavailable hosting remains
unverified rather than a fabricated pass.

## Implementation Handoff

The human maintainer approved these slices; each keeps the then-operative gate coherent:

| TASK | Parent criteria covered | Blockers |
| --- | --- | --- |
| [TASK-00007 — Make Development Runtime Worktree-Safe](../tasks/00007-TASK.md) | AC-01; runtime prerequisite for AC-02 | TASK-00001 |
| [TASK-00008 — Align Behavior Suites and Coverage](../tasks/00008-TASK.md) | AC-04/AC-05 | TASK-00006, TASK-00007 |
| [TASK-00009 — Deliver the Canonical Quality Gate](../tasks/00009-TASK.md) | AC-02/AC-03/AC-06; final integration of AC-05 | TASK-00002, TASK-00003, TASK-00004, TASK-00008 |

## Progress

Requirement and TASK split approved; all three TASKs are authored but not implemented. No runtime, tooling,
test-suite, coverage, or hosted workflow result is claimed.

PR #11's additional lean-gate handoff is preserved as [TASK-00016](../tasks/00016-TASK.md) under its original migrated
parent TICKET-00014. Its exact-100%-direct-Unit requirement conflicts with this record's deferred threshold, and its
scope overlaps the existing slices. Resolve that needs-info decision before gate/coverage implementation; this
schema migration neither chooses a coverage policy nor approves a duplicate implementation.
