# ADR 0001: Adopt the shared application foundation

- Status: Accepted
- Date: 2026-10-24
- Decision owner: Slim maintainer
- Authority: approved EPIC-00001, followed by the maintainer's direction to adopt the Agent OS non-domain foundation
  one-to-one now and revisit the completed frontend/authentication flow later

## Decision

Slim adopts the reusable Agent OS engineering, composition, testing, planning and delivery model by default.
[Engineering standards](../../docs/engineering/STANDARDS.md) own the current local rules;
[workflow bindings](../../docs/engineering/WORKFLOWS.md) keep shared skills at their provider and local facts here.
This is alignment, not a second copy of Agent OS planning or a claim that its domain/infrastructure exists in Slim.

Fight AccessControl owns identity/authorization Domain and Application behavior. Fight Common owns generic messaging,
transaction and reusable HTTP capabilities. Consume their installed public contracts directly; Composer release
artifacts, not development-checkout names, establish compatibility. Do not vendor package trees or create aliases
for package messages, safe Views, entities, handlers or repository capabilities.

Slim owns configuration, its composition root, routes, HTTP adapters/presentation, future persistence adapters and
actual application-specific policy. Dependencies point Adapter → Application → Domain. Composition and service-aware
routers may retrieve registered services; Domain/Application code may not. Constructors receive explicit dependencies.

An owned Application use case must satisfy all of these:

1. An owning package does not already supply the behavior.
2. It enforces real Slim policy or coordinates demonstrated ownership boundaries.
3. It has observable input, outcome/failure/effects and meaningful behavior tests.
4. It depends on injected inward capabilities, not concrete adapters or the container.

A forwarding/renaming wrapper fails this test. Shared command/query/event modules register one graph and all dispatch
traverses its pipelines. No alternate bus or direct handler invocation bypasses filters or authorization.

Actions map transport to one use case; Responders map safe outcomes without fetching or deciding policy. Keep the
simple root response simple. Authorization belongs to the authoritative use case across entry paths. Use package
safe-error middleware where released and compatible; consumer integration owns scope, safe diagnostics and routing.

The state-changing use-case owner declares transactions through the exact public installed capability, including
atomic state/audit/durable intent where required. Execute external effects only after commit. CQRS implies no
transaction/retry/durability/exactly-once guarantees. Future persistence decisions must prove shared-connection and
recovery behavior before claiming them.

## Enforcement and consequences

- TASK-00004 owns this ADR, PHP conventions and the approved callable-module conversion. Sorted
  `config/{parameters,common,application}/*.php` modules replace the explicit manifest and nested metadata loads.
- TASK-00003 owns the shared workflow binding and independent Spec/Standards and QA handoffs.
- TASK-00006 qualifies released package signatures and the lock; no aliases conceal transaction incompatibilities.
- TASK-00008/00009 own behavior/coverage and tool enforcement. Adopt the Agent OS coverage policy stated in the
  standards, not the superseded direct-Unit-only requirement. Missing business layers are explicitly N/A.
- TASK-00010 adopts safe HTTP handling with regression evidence; version claims alone never prove its behavior.

No bulk namespace moves, speculative layers, product routes or package-source changes follow from this ADR. Semantic
ownership, authorization placement and real orchestration remain review responsibilities even with static analysis.
Existing public behavior stays unchanged except explicitly documented, regression-tested HTTP error corrections.

## Deferred product decisions

Frontend/login flow and associated reusable tests will be adopted after the source authentication flow is complete,
through Slim-owned planning. No login, production persistence or browser journey is implemented by this ADR. MySQL
remains Slim's planned database; shared resources, test isolation and ingress still belong to WF-002. Other open
Wayfinder decisions remain open. Common 2.0, releases, publishing and create-project distribution remain separate.
