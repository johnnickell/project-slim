# Workers, Scheduling, and Mercure Contract

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** Symfony realtime contract
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-002, WF-005, WF-006

## Question

What reliable worker, scheduling, and private Mercure contract delivers background effects and realtime hints while
keeping authoritative state in the application APIs?

## Must decide

- Define Redis-backed message transport, serialization boundary, consumer topology, acknowledgements, retry,
  backoff, poison-message, and failure inspection behavior.
- Require a transactional outbox or an equivalently durable post-commit handoff so rollback publishes nothing and a
  committed database change cannot be silently lost between commit and Redis/Mercure publication.
- Classify which package events require delivery subscribers and which operations must remain synchronous.
- Define scheduled commands, cadence ownership, overlap prevention, idempotency, missed-run behavior, and operator
  execution.
- Define private Mercure topic schemas, publisher and subscriber authorization, token lifecycle, and tenant or
  principal isolation.
- Define reconnect, replay or loss tolerance, duplicate handling, ordering expectations, and degraded-mode UX.
- Require Mercure events to trigger authoritative refetch where correctness depends on current server state.
- Carry only minimal versioned invalidation data on authorized private topics and reject unauthorized subscription.
- Define health and verification evidence for workers, scheduler, Redis, and Mercure in the local runtime.

## Resolution boundary

This ticket settles asynchronous, scheduled, and realtime contracts and may use disposable prototypes. It does not
implement subscribers or UI, treat Mercure as authoritative storage, or claim production operations readiness. Queue,
schedule, topic, retry, and reconnect specifics remain fog until closure.

## Resolution

Open.
