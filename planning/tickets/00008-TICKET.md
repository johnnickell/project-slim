---
id: TICKET-00008
epic: EPIC-00001
title: Explicit Application Ownership and PHP Standards
status: done
order: 2
blocked_by:
---

# Explicit Application Ownership and PHP Standards

## Problem and Outcome

Slim shares the package ownership model but lacks a precise local ADR and consistently stated PHP/HTTP conventions.
Contributors need enforceable placement and naming rules without inventing layers or wrapping package-owned behavior.

## Included Use Cases

- Decide whether a use case is package-owned, genuinely Slim-owned orchestration, Domain policy, or an adapter concern.
  Use package messages/handlers/Views directly and justify new orchestration through real policy or ownership crossings.
- Compose dependencies explicitly and keep service location out of Domain/Application behavior. Preserve
  `App\ -> src/` and inward `Adapter -> Application -> Domain` dependencies.
- Review HTTP responsibilities: thin single-interaction Actions, dedicated Responders for real use cases, safe Views,
  explicit transport mapping, sanitized failures, and business authorization beyond middleware on every entry path.
- Apply strict types, final/readonly defaults, justified entity exceptions, capability names, camelCase PHP properties,
  snake_case transport/database fields, and multiline docblock conventions to existing owned code.
- Distinguish tool-enforceable syntax/dependencies from semantic ownership review; state transaction/delivery guarantees
  from behavior rather than assuming CQRS supplies them.

No new business commands, queries, events, permissions, or application transactions are introduced. Authorization and
secret-safe presentation are placement rules here; implementation of current HTTP error behavior belongs to TICKET-00012.

## Exclusions

Speculative layers, empty namespaces, package-source edits, renamed PSR/package contracts, new product use cases,
production persistence/authentication, arbitrary source reshuffles, and quality-tool installation owned by TICKET-00011.

## Dependencies and Sequencing

No requirement blocker. Establish the rules consumed by TICKET-00011 and TICKET-00012. Reconcile the local ADR with
WF-003 without deciding its complete API/OpenAPI contract or marking that investigation closed.

## Acceptance Criteria

- [x] **AC-01:** A Slim-local ADR states package versus consumer ownership, permitted orchestration, inward dependency
  direction, explicit injection, composition exceptions, and prohibitions on alias-only wrappers/speculative types.
- [x] **AC-02:** Local engineering guidance defines HTTP responsibilities, safe presentation and server authority,
  explicit CQRS/transaction/delivery semantics, PHP naming, readonly/final defaults, and documentation conventions.
- [x] **AC-03:** Existing owned source follows applicable conventions without changing public behavior or upstream
  contracts. The simple root response remains simple; no synthetic use case or Responder is added to satisfy a diagram.
- [x] **AC-04:** Enforcement responsibilities distinguish static tools from independent semantic review. Existing
  unresolved HTTP/persistence/package compatibility decisions remain explicit and assigned to their owning work.

## Verification

Review the actual owned classes and composition against the ADR, inspect callers for compatibility, and run existing
behavior tests plus the operative canonical gate. Tooling introduced later must use these accepted rules rather than
retroactively invent policy. No architecture/configuration tests are added to product suites.

## Implementation Handoff

[TASK-00004 — Establish Ownership and PHP Conventions](../tasks/00004-TASK.md) covers AC-01 through AC-04 and is
blocked by TASK-00001. Quality-gate enforcement and HTTP failure repair remain separate requirement outcomes.

## Child TASK status projection

<!-- planning:children:start -->
| Order | Record | Parent | Status | Dependency history | Unfinished blockers | Location |
| --- | --- | --- | --- | --- | --- | --- |
| 4 | [TASK-00004 — Establish Ownership and PHP Conventions](../tasks/00004-TASK.md) | [TICKET-00008](00008-TICKET.md) | done | [TASK-00001](../tasks/00001-TASK.md) | — | live |
<!-- planning:children:end -->

## Progress

Completed with sole child TASK-00004 on 2026-10-24 under automatic parent completion. ADR 0001, local standards and
entrypoint guidance are delivered; the approved amendment also converts composition to sorted callable modules and
separate shared command/query/event registrations. Direct module/syntax checks and the canonical build pass with
26 tests / 152 assertions, preserving existing behavior. No speculative source or upstream renaming was added.
Static gate enforcement, HTTP error repair and broader Wayfinder decisions remain with their existing owners.
Parent status is not independent review, QA, publication, merge or release; those outcomes remain separate.

Landing checkpoint (2026-10-24): TASK-00004 is independently accepted and QA-passed at `d62fb30`. Land preserves
its effective application diff while reconciling accepted TASK-00017; fresh full/focused and behavioral compatibility
checks pass on PHP 8.5.12. This terminal parent stays done; EPIC-00001 remains open. Combined
[PR #16](https://github.com/johnnickell/project-slim/pull/16) publishes it with TASK-00003/00006; human review/merge is separate.
