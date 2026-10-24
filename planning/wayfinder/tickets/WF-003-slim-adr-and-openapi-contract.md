# Slim ADR and OpenAPI Contract

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** Qualified reusable Agent OS wire contract
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-001, WF-002

## Question

What Slim HTTP architecture and authoritative OpenAPI workflow preserve package boundaries while providing a stable,
typed `/api/v1/access` contract?

## Must decide

- Apply the accepted Slim ownership ADR and source application's capability-first Action/Responder placement,
  retaining only demonstrated Slim integration differences.
- Settle command and query dispatch, request validation, authentication and authorization middleware, and the
  translation of application results into HTTP.
- Define typed JSend success, fail, and error envelopes plus validation, authorization, not-found, conflict,
  throttling, and unexpected-error behavior.
- Define versioned route conventions under `/api/v1/access`, content negotiation, identifiers, and operation naming.
- Generate one Slim-owned OpenAPI 3.1 document in one pass from installed Fight AccessControl
  `resources/openapi/` components and Slim-owned Actions, request/response DTOs, routes, security declarations, and
  project components; do not generate and merge separate specs.
- Own the generator command, checked-in artifact, Swagger UI, servers, tags, paths, operations, security schemes,
  status codes, framework errors, and drift check while qualifying reusable source paths, methods, operation IDs, payloads,
  safe errors, and authentication behavior.
- Record the accepted architecture in a Slim-local ADR before implementation TASKs are created.

## Resolution boundary

This ticket settles HTTP structure and contract authority through a disposable prototype and ADR. It does not settle
the complete operation catalog, persistence mechanics, final security values, or production code. Exact endpoints and
schemas remain owned by WF-008.

## Resolution

Open. The 2026-10-24 direction adopts the reusable Agent OS foundation instead of the earlier Symfony parity
assumption. [ADR 0001](../../adr/0001-application-ownership-and-orchestration.md) now settles bounded ownership and
composition. TASK-00010 still owns the starter safe-error correction; this broader API/OpenAPI contract remains
open and must qualify source/package capabilities before adopting endpoints, schemas or authentication behavior.
