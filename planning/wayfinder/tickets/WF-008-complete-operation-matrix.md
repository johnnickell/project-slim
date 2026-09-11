# Complete Operation Matrix

**Labels:** `wayfinder:research`
**Mode:** AFK
**Status:** Open
**Gate:** Symfony operation matrix
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-001, WF-003, WF-004, WF-005, WF-006, WF-007

## Question

What complete operation matrix accounts for every released AccessControl capability and every required product journey
without forcing composition-only or operator capabilities into HTTP?

## Must decide

- Reconcile the WF-001 capability inventory with the persistence, security, authorization, worker, scheduler, and
  realtime contracts.
- Enumerate all user, agent, administrator, recovery, invitation, credential, session, role, permission, policy, and
  audit journeys supported by the released packages.
- For each HTTP operation, define method, path, inputs, typed JSend output, errors, permission, authentication,
  audit effect, idempotency or concurrency behavior, pagination, and stable OpenAPI operation ID.
- For each non-HTTP capability, deliberately classify its CLI, worker/subscriber, scheduled, or composition-only
  boundary and document how it is verified.
- Identify realtime notifications and authoritative refetch behavior associated with each mutating journey.
- Prove bidirectional completeness: every released capability is classified and every exposed operation maps to a
  released capability or an explicitly consumer-owned composition concern.
- Map every exposed row to a Slim Action/Responder pair, Fight Common CQRS dispatch, package command/query or
  synchronous security service, transaction owner, audit effect, and post-commit side effects.
- Record denied, unauthenticated, invalid, missing, conflicting, expired, revoked, replayed, throttled, and concurrent
  outcomes wherever they can occur.

## Resolution boundary

This ticket owns the complete delivery and operation catalog. It does not implement endpoints, adapters, commands,
workers, or UI and must not expose classes merely to make the matrix appear complete. Unresolved methods, paths,
schemas, permissions, concurrency, pagination, and operation IDs remain fog owned here.

## Resolution

Open.
