# React SPA Adoption and Slim Adaptation

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** Completed and accepted Agent OS frontend/authentication reference
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-005, WF-008

## Question

How should Slim adopt the finished Agent OS frontend/login flow once, then own and adapt a complete editable React SPA under
`client/` without creating a shared runtime frontend package?

## Must decide

- Verify the finished Agent OS client and inventory its reusable routes, screens, states, components, journeys, accessibility
  behavior, generated types, realtime behavior, and build assumptions before adoption.
- Record the immutable accepted source reference and exact copy manifest in authorized ignored evidence, then leave Slim with independently
  owned, editable `client/` source.
- Adopt the finished source client's build/style tooling, development behavior, deterministic production output,
  asset manifests and cache busting. Reconcile Slim static/fallback routing rather than independently prescribing
  ESBuild or `public/dist/` before qualifying that source.
- Regenerate OpenAPI client types from Slim's own one-pass spec and enforce drift without hand-maintained schemas.
- Adapt authentication startup, refresh, logout, revocation, authorization-aware navigation, errors, and recovery to
  the WF-005 and WF-008 contracts.
- Define Mercure subscription, reconnect, degraded behavior, and authoritative refetch UX.
- Establish responsive and accessible human journeys with focused browser evidence for the complete operation matrix.
- Limit adaptations to environment/configuration and Slim-facing integration; require a source-drift review for
  substantive divergence from the accepted source client.

## Resolution boundary

This ticket settles adoption and adaptation through a disposable prototype after its dependencies are verified. It
does not copy an unfinished client, create a runtime-shared frontend package, implement the final SPA, or carry private
source identities or derivation claims into public artifacts. The exact UI inventory and build mechanics remain fog
until closure.

## Resolution

Open. On 2026-10-24 the maintainer selected Agent OS's completed frontend/login flow and its applicable reusable
tests as the adoption source, superseding the earlier Symfony source assumption. Default to one-to-one non-domain
adoption; exclude Agent OS-specific product/domain behavior. Revisit after authentication completion and verify an
accepted source snapshot then. This selection neither claims that the source flow is complete nor authorizes its
implementation now; WF-005/WF-008 and the eventual local product TASKs remain required.
