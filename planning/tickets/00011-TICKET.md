---
id: TICKET-00011
epic: EPIC-00001
title: Reproducible Runtime and One Quality Gate
status: in-progress
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
the gate, certification matrices/no-dev checks, thresholds beyond the adopted coverage policy, tests of quality tools, and
placeholder production code or routes created only to satisfy static analysis or coverage.

## Dependencies and Sequencing

Final acceptance depends on TICKET-00007's working planning validation, TICKET-00008's rules, TICKET-00009's retirement,
and TICKET-00010's selected released lock. Child TASKs should use only their true blockers: runtime isolation can be
implemented before all final gate prerequisites exist. Reconcile wrapper decisions with WF-002 without implementing
or closing its full future runtime investigation.

## Acceptance Criteria

- [x] **AC-01:** Runtime setup, lifecycle, test, and exec commands are documented and verified on a clean checkout and
  concurrently isolated worktrees, with no fixed-port/resource collisions or cleanup of unrelated resources.
- [ ] **AC-02:** `./bin/build` uses the running service and a PHP orchestrator with the named fail-fast phases. Missing
  prerequisites fail clearly; no per-build image rebuild, dependency maintenance, or new Python gate orchestration
  is introduced. Existing planning validation may remain Python.
- [ ] **AC-03:** PHPCS, PHPStan, Deptrac, and Rector are configured for actual owned code and accepted rules without
  speculative source, unexplained suppression, or claims that static tools prove semantic ownership.
- [x] **AC-04:** Product suites prove meaningful success/rejection/failure and integration effects. Tooling/configuration
  tests are removed or replaced by direct checks where needed; certification-only checks stay retired. Test
  dispositions preserve important application protections rather than optimize counts.
- [ ] **AC-05:** Each configured suite runs exactly once; separate unit coverage states denominator, driver, exclusions,
  and gaps. Enforce the explicitly adopted meaningful Domain/Application line threshold from TASK-00008; Adapter
  gaps stay visible. Absent business layers are N/A. Coverage is not protocol or security proof.
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

## Child TASK status projection

<!-- planning:children:start -->
| Order | Record | Parent | Status | Dependency history | Unfinished blockers | Location |
| --- | --- | --- | --- | --- | --- | --- |
| 7 | [TASK-00007 — Make Development Runtime Worktree-Safe](../tasks/00007-TASK.md) | [TICKET-00011](00011-TICKET.md) | done | [TASK-00001](../tasks/00001-TASK.md) | — | live |
| 8 | [TASK-00008 — Align Behavior Suites and Coverage](../tasks/00008-TASK.md) | [TICKET-00011](00011-TICKET.md) | done | [TASK-00006](../tasks/00006-TASK.md), [TASK-00007](../tasks/00007-TASK.md) | — | live |
| 9 | [TASK-00009 — Deliver the Canonical Quality Gate](../tasks/00009-TASK.md) | [TICKET-00011](00011-TICKET.md) | ready-for-agent | [TASK-00002](../tasks/00002-TASK.md), [TASK-00003](../tasks/00003-TASK.md), [TASK-00004](../tasks/00004-TASK.md), [TASK-00008](../tasks/00008-TASK.md) | — | live |
<!-- planning:children:end -->

## Progress

Current handoff (TASK-00008, 2026-10-25): [suite/coverage implementation](../tasks/00008-TASK.md#completion-notes)
is locally verified: 30 tests / 98 assertions in one PHPUnit run, separate Unit/Integration/Functional attribution,
Domain/Application N/A and visible Adapter Unit gaps. Behavioral dispositions and direct non-product checks are
recorded; the released lock and production behavior are unchanged. Independent Review/QA and publication remain
pending. AC-04 is implemented; final gate integration of AC-05 remains TASK-00009, now first ready.
TASK-00009 and required hosted verification keep this requirement open; no eligible parent completion is deferred.

### Historical TASK-00007 merge reconciliation

Current handoff (2026-10-25): [TASK-00007's merge reconciliation](../tasks/00007-TASK.md#current-merge-reconciliation--2026-10-25)
confirms [PR #18](https://github.com/johnnickell/project-slim/pull/18) merged into `develop` at
`690225d5a6bdb27bb6533fe8c328a3f05f98e031`. The merge tree equals verified administrative closeout `f8f82c5`;
Review acceptance and QA PASS remain anchored to `8b7a409`, with no implementation change across that bridge.
No runtime delivery/merge action remains. TASK-00008 is first ready, TASK-00009 still waits for it, and these
unfinished children keep this requirement open. Final gate/coverage and hosted integration acceptance remain
outstanding; no future topology or WF-002 closure is implied.

### Historical TASK-00007 delivery checkpoint

[TASK-00007](../tasks/00007-TASK.md#independent-acceptance-and-delivery-checkpoint) is independently
accepted and QA-passed for candidate `8b7a4092de397d461fa07f910d1ff9d4aab0f3ee`: it delivers the stateless
runtime boundary with explicit clean-worktree setup, concurrent loopback services, checkout/project ownership,
running-service exec/tests, prerequisite/exit failures and owned cleanup. Review R-01's ambient orphan deletion
is resolved without changing its historical revise report. [PR #18](https://github.com/johnnickell/project-slim/pull/18)
is the draft delivery PR; administrative closeout/final-head verification is pending at this checkpoint, not a
merge claim. TASK-00008 remains first ready; TASK-00009 still waits for it. These unfinished children keep this
requirement open.
No new suite/coverage enforcement, replacement gate, future topology or hosted integration result is claimed.

The maintainer's 2026-10-24 [adoption amendment](../epics/00001-EPIC.md#current-adoption-amendment--2026-10-24)
supersedes both earlier coverage proposals: use Agent OS's single all-suite execution, 100% meaningful Domain/
Application executable-line coverage, separate suite attribution and visible Adapter gaps (100% practical target).
[TASK-00016](../tasks/00016-TASK.md) preserves the incoming handoff as wontfix; its overlapping implementation belongs
to TASK-00005/00006/00008/00009. No second gate, delivered coverage or waived hosted evidence is implied.
