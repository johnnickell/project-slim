# Implementation Handoff Acceptance Contract

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** Human approval of the handoff
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-001, WF-002, WF-003, WF-004, WF-005, WF-006, WF-007, WF-008, WF-009

## Question

How should the closed Slim AccessControl decisions become a coherent epic, PRDs, and independently verifiable vertical
implementation tickets with no unresolved architectural decisions hidden inside execution work?

## Must decide

- Confirm every preceding ticket is closed and its decisions are consistent, traceable, and free of unresolved fog
  required for implementation.
- Define one epic destination and coherent PRD boundaries spanning runtime, HTTP/OpenAPI, persistence/bootstrap,
  security/authorization, workers/realtime, operation delivery, and the SPA.
- Slice implementation tickets vertically so each delivers observable product behavior with its required adapters,
  wiring, contract documentation, and meaningful tests.
- Define dependency ordering, integration seams, migration constraints, and safe parallel-work boundaries.
- Define acceptance evidence for unit code coverage, real integration boundaries, selected functional journeys,
  OpenAPI and generated-client drift, local Docker behavior, and the canonical `./bin/build` gate.
- Require one valid checked-in Slim-generated document and rendered local Swagger UI, normalized Symfony parity,
  generated-client compilation, unauthorized operation/private-subscription rejection, refresh rotation/reuse,
  invitation-led bootstrap, durable outbox retry/recovery, scheduler overlap, client-source drift, and failure recovery.
- Link the resulting epic, PRDs, and tickets from the closed map and leave release, deployment, and publication work
  outside the handoff unless separately authorized.

## Resolution boundary

This ticket may create planning artifacts only after all upstream decisions and external client evidence are closed.
It does not implement application behavior, publish a release, deploy infrastructure, or collapse multiple vertical
journeys into an unverifiable infrastructure-first ticket.

## Resolution

Open.
