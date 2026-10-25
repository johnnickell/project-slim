# Slim engineering standards

The maintainer selected one-to-one adoption of Fight Agent OS's reusable, non-domain foundation on 2026-10-24.
These local rules govern Slim; the [ownership ADR](../../planning/adr/0001-application-ownership-and-orchestration.md)
and [shared workflow binding](WORKFLOWS.md) state the scope and substitutions. Do not create abstractions or
application features merely to match source layout. Adopt completed frontend/authentication behavior and its
applicable tests in a later locally approved slice, not unfinished provider work.

## Ownership and architecture

Dependencies point `Adapter → Application → Domain`, with `App\` mapped directly to `src/`.
Domain owns concepts, invariants and policy; Application coordinates use cases through injected inward capabilities;
Adapter owns HTTP, persistence, presentation and external services. Composition may know all layers. Domain and
Application must not use a service locator or depend on concrete adapters/frameworks.

Use public Fight Common and AccessControl capabilities, messages, handlers, events and safe Views directly. No copied
package source, namespace aliases or forwarding wrappers. Owned orchestration requires missing package behavior,
real Slim policy or multiple ownership boundaries, observable input/outcomes/failures and injected inward contracts.
Do not reconstruct entity policy from getters or introduce speculative Service/Manager/Helper buckets.

Name capabilities for behavior, without an Interface suffix; preserve public PSR and package names. Organize by
cohesive responsibility, then capability/transport as useful, not class counts or one-class diagram layers. Prefer
small domain-facing interfaces that hide coordination without hiding authorization, failure or transaction guarantees.

## Composition and messaging

`config/services.php` loads sorted `config/{parameters,common,application}/*.php` modules exactly once, in that
directory order. Every matched file returns `callable(Container): void`. No file manifest, nested module loads,
filename exceptions or argv-selected profiles. Keep metadata outside these globs.

Common command/query/event modules own their shared buses, routers, pipelines and aliases. Application modules
register lazy services/handlers without replacing buses. Construct services from other shared registrations in the
same container; shared means per container, not static globals. Scope stateful infrastructure explicitly and clean
it up on both success and failure. Registration is neither execution nor access control.

Dispatch every command/query through its configured bus, including nested orchestration; inject buses, not handlers.
Commands express intent, queries read without business mutation, events report established facts. CQRS alone implies
no transaction, retries, ordering, durability, idempotency or exactly-once delivery. The use-case owner declares those
guarantees. Keep authoritative state and required durable intent atomic; external effects happen after commit.
Honor exact installed public transaction signatures instead of hiding compatibility differences behind aliases.

## HTTP

Use one thin final Action per interaction, with `handle()` as its entrypoint. API callable registration uses
`Class:handle`. Map validated transport input and trusted actor/target context into one package or justified owned
use case. Responders present through `respond()`, owning status, headers and explicit safe representation—not data
fetching, policy or transactions. The existing plain root response needs no synthetic use case or Responder.

Use safe Views rather than entities/secrets across presentation boundaries. PHP properties are camelCase; JSON
and database fields are snake_case. Scope JSend explicitly. Do not map arbitrary lookup failures to 404, infer
permissions from role names/UI visibility, or make middleware the only authorization boundary. Protected use cases
must enforce authoritative permission/ownership rules on every entry path. A raw package bus is trusted in-process
infrastructure, never an authenticated public API.

Prefer released Common safe HTTP middleware and its public extension points over a duplicate error framework.
Document intentional wire changes and preserve routing headers. Public errors and diagnostics must not expose raw
exception messages, request bodies, credentials, tokens, configuration values or stack traces.

## PHP and naming

Use strict types, constructor injection, guard clauses, final classes and readonly properties/value objects, with
justified Doctrine entity exceptions. Name messages for intent/fact and handlers with Handler. Use Fight helpers
where clearer, not to hide contracts. Multiline docblocks use capitalized active-verb summaries without terminal
periods; constructors say `Constructs ClassName`, inherited behavior uses multiline `@inheritDoc`.

When applicable, order API attributes: OpenAPI, input source, Validation, access requirements, other metadata.
Keep each attribute in its own block on a supported target; source order is not execution/authorization order.
Pi/TypeScript capability files use kebab-case, functions camelCase and exported types PascalCase. Only manifest-loaded
Pi entrypoints use `-extension.ts`; internal integrations and reusable logic keep their actual capability names.

## Behavior tests and coverage

Prove owned behavior and meaningful package integrations at the narrowest useful unit/integration/functional seam.
Assert meaningful success, rejection, failure, state and external effects, not merely mocked call sequences. Ordinary
features do not require TDD; bugs require a failing regression before repair where possible, with justified exceptions.
Keep smoke behavior and required protections. Never manufacture product endpoints, placeholder layers or tests for
percentages. Do not test upstream internals, wiring, tooling, generated files, wrappers or test infrastructure as
product behavior; validate those directly with their owning commands.

Adopt Agent OS's coverage model: one all-suite execution, 100% meaningful Domain/Application executable-line coverage,
separately reported Unit/Integration/Functional attribution, and visible Adapter gaps with 100% a practical target.
Overlapping attribution is not additive; combined coverage is not Unit coverage. Report driver, denominator, exact
exclusions and gaps. An absent business layer is explicitly N/A, not fabricated code or a claimed 100% result.
Exclude composition/generated code, not uncovered behavior. This policy supersedes both the earlier deferred-threshold
proposal and TASK-00016's direct-Unit-only exact statement requirement; historical text remains provenance.
The [single-run reporter](TESTING.md) implements this policy; the canonical gate consumes the same execution.

## Verification and delivery

Use repository wrappers and `./bin/build`, with explicit dependency maintenance outside the gate. The
[canonical gate](QUALITY-GATE.md) preserves read-only host planning before Docker, then runs PHP-orchestrated,
fail-fast syntax, shipped Fight PHPCS, PHPStan, Deptrac, Rector dry-run and one all-suite coverage execution in the
running service. Its documented scan scopes are not semantic ownership proof. Add frontend checks with the adopted
frontend, not placeholders. [TASK-00009](../../planning/tasks/00009-TASK.md#post-merge-reconciliation--pr-20)
records actual required hosted acceptance and final delivery proof; future changes must preserve their own explicit
hosted requirements. Live delivery metadata is checked separately under the local workflow binding.

Keep tests/tool output, warnings, skips and unavailable evidence visible. Semantic ownership and policy require
independent review beyond tools. Preserve explicitly required hosted verification; a local pass never supplies it.
Follow [delivery and shared workflows](WORKFLOWS.md). Retired framework certification stays retired.
