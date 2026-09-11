# Doctrine Persistence and Bootstrap Contract

**Labels:** `wayfinder:prototype`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-001, WF-003

## Question

How should Slim implement durable AccessControl ports with Doctrine while preserving transactional integrity,
portable verification, managed policy, and a safe first-administrator bootstrap?

## Must decide

- Define mapping ownership for package domain objects without modifying or copying package source.
- Map repository ports to Doctrine adapters and settle identity, timestamp, uniqueness, locking, and pagination
  behavior.
- Define migration ownership, generation, review, execution, rollback expectations, and schema validation.
- Settle transaction boundaries so state changes and audit records are atomic, including failure behavior.
- Define meaningful MySQL verification for migrations, mapping, locking, uniqueness, and concurrency; no PostgreSQL
  lane or abstraction requirement belongs in this starter family.
- Define convergent managed-policy reconciliation that preserves unrelated authored records and fails safely on
  collisions.
- Define an invitation-led administrator bootstrap with repeatability, secret handling, and operator evidence.

## Resolution boundary

This ticket settles persistence and bootstrap contracts and may use disposable prototypes. It does not implement the
production adapters or migrations, select endpoint shapes, permit destructive reconciliation, or introduce public
self-registration. Exact mappings and mechanics remain fog until closure.

## Resolution

Open.
