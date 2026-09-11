# React SPA Adoption and Slim Adaptation

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** Immutable accepted Symfony client reference
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-005, WF-008

## Question

How should Slim adopt the finished Symfony client once, then own and adapt a complete editable React SPA under
`client/` without creating a shared runtime frontend package?

## Must decide

- Verify the finished Symfony client and inventory its routes, screens, states, components, journeys, accessibility
  behavior, generated types, realtime behavior, and build assumptions before adoption.
- Record the immutable accepted Symfony source reference and exact copy manifest, then leave Slim with independently
  owned, editable `client/` source.
- Define ESBuild and Sass inputs, development behavior, deterministic production output in `public/dist/`, asset
  manifests, cache busting, and Slim static or fallback routing.
- Regenerate OpenAPI client types from Slim's own one-pass spec and enforce drift without hand-maintained schemas.
- Adapt authentication startup, refresh, logout, revocation, authorization-aware navigation, errors, and recovery to
  the WF-005 and WF-008 contracts.
- Define Mercure subscription, reconnect, degraded behavior, and authoritative refetch UX.
- Establish responsive and accessible human journeys with focused browser evidence for the complete operation matrix.
- Limit adaptations to environment/configuration and Slim-facing integration; require a source-drift review for
  substantive divergence from the accepted Symfony client.

## Resolution boundary

This ticket settles adoption and adaptation through a disposable prototype after its dependencies are verified. It
does not copy an unfinished client, create a runtime-shared frontend package, implement the final SPA, or carry private
source identities or derivation claims into public artifacts. The exact UI inventory and build mechanics remain fog
until closure.

## Resolution

Open.
