# Wayfinder Map: Slim AccessControl Application

**Label:** `wayfinder:map`
**Status:** Active

> This map is an **index, not a store**. Each material decision lives in exactly one linked ticket under
> `tickets/`; this map only summarizes the linked resolutions and shows the next decision frontier.

## Destination

An implementation-ready plan for a complete Slim starter that composes the released Fight Common and Fight
AccessControl packages into a local Docker application, covers every consumer-relevant AccessControl journey,
generates its own authoritative OpenAPI document from shared package schemas plus Slim-owned operations, delivers
private realtime updates through Mercure, and owns an
editable React SPA in `client/` compiled into `public/dist/`.

**Done** = WF-001 through WF-010 are closed; every released package capability has an intentional HTTP, CLI,
worker, or composition-only delivery boundary; the Symfony client dependency has been verified; remaining fog is
resolved or explicitly excluded; and WF-010 links the resulting epic, PRDs, and independently verifiable
implementation tickets.

## Notes

- This charting slice changes no runtime behavior, public API, schema, environment contract, container, or generated
  client.
- Slim owns composition, routes, middleware, Actions, Responders, HTTP, persistence and integration adapters,
  presentation, local runtime, and the independently maintained SPA. Fight Common and Fight AccessControl remain
  public Composer dependencies; package source and unpublished internals must not be copied.
- The target architecture preserves `Domain <- Application <- Adapter`. A complete consumer boundary does not mean
  exposing every public PHP class over HTTP.
- `/api/v1/access`, typed JSend responses, asymmetric access JWTs with rotating refresh sessions, Mercure, and an
  editable React client are target assumptions to validate in the owning tickets, not contracts established by this
  map.
- Docker evidence qualifies local development only. Production deployment and production-readiness certification
  require separate authority.
- Private reference material may inform generic requirements only. Public planning artifacts must not contain
  private identities, paths, hashes, package internals, or derivation claims.
- Implementation requires installable Fight Common 1.2.0 and Fight AccessControl 0.2.0. AccessControl owns only
  scan-only component schemas; Slim owns the complete document and matches Symfony's client-facing wire contract.
- Slim generates exactly one OpenAPI 3.1 artifact in one pass from installed package resources and Slim-owned
  Actions, DTOs, routes, security declarations, and project components; it never merges separate specs.

## Decisions so far

1. **[Released Package Contract Audit](tickets/WF-001-released-package-contract-audit.md) is open.** It will establish the released public capability inventory and intentional delivery classification.
2. **[Local Development Runtime Contract](tickets/WF-002-local-development-runtime-contract.md) is open.** It will settle the complete isolated Docker development runtime and environment contract.
3. **[Slim ADR and OpenAPI Contract](tickets/WF-003-slim-adr-and-openapi-contract.md) is open.** It will settle the Slim HTTP architecture, response language, error boundary, versioned path, and OpenAPI authority.
4. **[Doctrine Persistence and Bootstrap Contract](tickets/WF-004-doctrine-persistence-and-bootstrap-contract.md) is open.** It will settle durable adapters, atomicity, reconciliation, and first-administrator bootstrap.
5. **[Authentication and Account Security Contract](tickets/WF-005-authentication-and-account-security-contract.md) is open.** It will settle browser-safe authentication, credentials, throttling, restoration, logout, and revocation.
6. **[Principal and Authorization Mapping](tickets/WF-006-principal-and-authorization-mapping.md) is open.** It will settle User and Agent principals, managed authorization data, enforcement, invalidation, and audit boundaries.
7. **[Workers, Scheduling, and Mercure Contract](tickets/WF-007-workers-scheduling-and-mercure-contract.md) is open.** It will settle asynchronous, scheduled, and private realtime delivery behavior.
8. **[Complete Operation Matrix](tickets/WF-008-complete-operation-matrix.md) is open.** It will account for every released capability and product journey across all delivery boundaries.
9. **[React SPA Adoption and Slim Adaptation](tickets/WF-009-react-spa-adoption-and-slim-adaptation.md) is open.** It will settle one-time client adoption, independent ownership, build output, browser lifecycle, realtime, and human journeys.
10. **[Implementation Handoff Acceptance Contract](tickets/WF-010-implementation-handoff-acceptance-contract.md) is open.** It will synthesize closed decisions into the canonical implementation-planning hierarchy.

## Tickets

| Ticket | Type | Mode | Status | Depends On | Gate |
|---|---|---|---|---|---|
| [WF-001 — Released Package Contract Audit](tickets/WF-001-released-package-contract-audit.md) | Research | AFK | **Open** | — | Installable Fight Common 1.2.0 and Fight AccessControl 0.2.0 |
| [WF-002 — Local Development Runtime Contract](tickets/WF-002-local-development-runtime-contract.md) | Grilling | HITL | **Open** | — | — |
| [WF-003 — Slim ADR and OpenAPI Contract](tickets/WF-003-slim-adr-and-openapi-contract.md) | Prototype | HITL | **Open** | WF-001, WF-002 | Symfony canonical wire contract |
| [WF-004 — Doctrine Persistence and Bootstrap Contract](tickets/WF-004-doctrine-persistence-and-bootstrap-contract.md) | Prototype | HITL | **Open** | WF-001, WF-003 | — |
| [WF-005 — Authentication and Account Security Contract](tickets/WF-005-authentication-and-account-security-contract.md) | Grilling | HITL | **Open** | WF-003, WF-004 | Symfony authentication contract |
| [WF-006 — Principal and Authorization Mapping](tickets/WF-006-principal-and-authorization-mapping.md) | Grilling | HITL | **Open** | WF-004, WF-005 | — |
| [WF-007 — Workers, Scheduling, and Mercure Contract](tickets/WF-007-workers-scheduling-and-mercure-contract.md) | Prototype | HITL | **Open** | WF-002, WF-005, WF-006 | Symfony realtime contract |
| [WF-008 — Complete Operation Matrix](tickets/WF-008-complete-operation-matrix.md) | Research | AFK | **Open** | WF-001, WF-003 through WF-007 | Symfony operation matrix |
| [WF-009 — React SPA Adoption and Slim Adaptation](tickets/WF-009-react-spa-adoption-and-slim-adaptation.md) | Prototype | HITL | **Open** | WF-005, WF-008 | Immutable accepted Symfony client reference |
| [WF-010 — Implementation Handoff Acceptance Contract](tickets/WF-010-implementation-handoff-acceptance-contract.md) | Grilling | HITL | **Open** | WF-001 through WF-009 | Human approval of the handoff |

## Blocking relationships

```text
Installable Fight Common 1.2.0 + Fight AccessControl 0.2.0 ──→ WF-001 ──┬──→ WF-003 ──→ WF-004 ──→ WF-005 ──→ WF-006 ──→ WF-007 ──┐
                                             │         │           │                    │              │
WF-002 ──────────────────────────────────────┘         └───────────┴────────────────────┴──→ WF-008 ──┤
WF-005 ─────────────────────────────────────────────────────────────────────────────────────→ WF-009 ──┤
WF-008 ─────────────────────────────────────────────────────────────────────────────────────→ WF-009 ──┤
Symfony wire/realtime/operation/client gates ───────────────────────────────────────────────→ WF-003/WF-007/WF-008/WF-009
WF-001 through WF-009 ──────────────────────────────────────────────────────────────────────→ WF-010
```

## Frontier

[WF-002 — Local Development Runtime Contract](tickets/WF-002-local-development-runtime-contract.md) is the one
next grillable decision.

## Not yet specified (fog)

- WF-001 owns the exact released capability inventory and whether each capability is HTTP, CLI, worker, or
  composition-only.
- WF-002 owns image and service versions, ports, health probes, mounts, worker and scheduler process topology,
  wrapper semantics, worktree-safe isolation, and every `.env.example` key and default.
- WF-003 owns Action and Responder namespaces and signatures, CQRS dispatch seams, validation mechanics, JSend and
  error schemas, the exact `/api/v1/access` route shape, operation naming, and one-pass OpenAPI generation/drift.
- WF-004 owns Doctrine mappings, repository mechanics, migration topology, transaction and audit atomicity,
  MySQL certification, managed-policy reconciliation, and administrator bootstrap details.
- WF-005 owns JWT algorithms and claims, key rotation, access and refresh lifetimes, cookie attributes, CSRF and
  origin policy, throttling values, credential rules, startup restoration, logout, and revocation semantics.
- WF-006 owns the exact User and Agent principal model, role and permission catalog, managed-policy ownership,
  enforcement points, cache keys and invalidation, and authorization audit events.
- WF-007 owns transports, queue names, retry and failure policy, scheduled command cadence, subscriber topology,
  Mercure topic schemas and authorization, reconnect behavior, and authoritative refetch triggers.
- WF-008 owns methods, paths, request and response schemas, permissions, audit effects, idempotency and concurrency,
  pagination, OpenAPI operation IDs, and deliberate non-HTTP classifications for every operation.
- WF-009 owns the verified source-client inventory, one-time adoption boundary, independently owned component and
  route inventory, ESBuild and Sass configuration, generated-type workflow, authentication lifecycle, accessibility,
  realtime UX, fallback behavior, and human journey evidence.
- WF-010 owns epic and PRD boundaries, vertical implementation ticket size and ordering, acceptance evidence, and
  the final definition of implementation readiness.

## Out of scope

- Production deployment, infrastructure provisioning, DNS, release qualification, package publication, tags, or
  production-readiness certification.
- Public self-registration unless separately authorized by a future local contract.
- Copying Fight Common or Fight AccessControl internals into Slim.
- A shared runtime frontend package or any coupling that prevents `client/` from being independently edited.
- Implementing containers, routes, schemas, persistence, authentication, workers, realtime, or client behavior while
  this map is being charted.
