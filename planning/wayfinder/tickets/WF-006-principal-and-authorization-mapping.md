# Principal and Authorization Mapping

**Labels:** `wayfinder:grilling`
**Mode:** HITL
**Status:** Open
**Gate:** —
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** WF-004, WF-005

## Question

How should Slim map distinct User and Agent principals to roles, permissions, managed policy, authorization
enforcement, cache behavior, and audit evidence?

## Must decide

- Preserve User and Agent as distinct principal kinds with explicit identity, authentication, lifecycle, and display
  boundaries.
- Define the canonical role and permission catalog and which entries are application-managed versus authored.
- Define assignment, removal, listing, effective-permission, and managed-policy reconciliation behavior.
- Locate authorization checks across middleware, Actions, application dispatch, CLI, workers, subscribers, and
  composition-only services so no alternate delivery path bypasses policy.
- Define authorization-cache keys, safe invalidation triggers, stale-read tolerance, and authoritative fallbacks.
- Define audit subjects, actors, targets, decisions, reasons, and correlation data without leaking secrets.

## Resolution boundary

This ticket settles the principal and authorization model across delivery boundaries. It does not invent package
capabilities, finalize HTTP paths, implement policy adapters, or conflate machine Agents with human Users. Exact
catalog entries and cache mechanics remain fog until closure.

## Resolution

Open.
