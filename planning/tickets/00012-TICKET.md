---
id: TICKET-00012
epic: EPIC-00001
title: Safe and Predictable HTTP Failures
status: ready-for-agent
order: 6
blocked_by: TICKET-00008, TICKET-00010, TICKET-00011
---

# Safe and Predictable HTTP Failures

## Problem and Outcome

The current pipeline exposes exception messages and treats malformed JSON as a server error. Callers need explicit,
safe failures that distinguish rejected input from unexpected failures while preserving the starter's intended root
and routing behavior.

## Included Use Cases

- A caller receives the unchanged successful root response.
- A caller sends malformed JSON and receives a documented client-error status and safe representation rather than
  a server failure or raw parser exception text.
- A caller reaches an unexpected downstream failure and receives a generic server-error representation without
  arbitrary exception text, stack traces, configuration values, credentials, or internal identifiers.
- A caller reaches an unknown route or unsupported method and receives the documented transport outcome, preserving
  intended status semantics and relevant headers without exposing arbitrary framework exception text.
- Maintainers can identify the scope of JSend and the compatibility change from existing error assertions. The
  current production bootstrap continues to expose no fixture-only API routes.

No new business commands, queries, events, permissions, authentication, or product state changes apply. Validation
concerns the existing HTTP input boundary. Security concerns error disclosure; business authorization implementation
remains outside this requirement.

## Exclusions

New API operations, a complete AccessControl/OpenAPI contract, authentication or permission enforcement, production
persistence, package-source modifications, synthetic use cases/Responders for the root, and test-only production routes.

## Dependencies and Sequencing

Use TICKET-00008's HTTP responsibilities and reconcile the bounded current error contract with WF-003 without closing
that broader investigation. Final acceptance uses TICKET-00010's released lock and TICKET-00011's canonical gate;
regression design need not wait for all gate work. Exact representations must be explicit in the implementation TASK
before repair, not guessed from arbitrary exception messages or undisclosed package internals.

## Acceptance Criteria

- [ ] **AC-01:** Malformed JSON is classified as a documented client error, with safe status/body semantics and a
  regression that fails against the old behavior before repair when technically possible.
- [ ] **AC-02:** Unexpected downstream exceptions produce a documented generic server error, with regression evidence
  that sensitive-looking sentinel text does not enter the public response. No arbitrary exception passthrough remains.
- [ ] **AC-03:** Intended root, not-found, and method-not-allowed behavior, including relevant headers, remains explicit
  and tested. Fixture-only routes stay outside production bootstrap.
- [ ] **AC-04:** JSend scope, safe mappings, and intentional wire-compatibility changes are documented. HTTP handling
  owns transport representation without recreating Domain policy or treating an arbitrary lookup as a public 404.
- [ ] **AC-05:** Tests prove the actual owned boundary and important integration behavior without manufacturing product
  endpoints solely for tests. Focused regression and final canonical-gate evidence are recorded on the released lock.

## Verification

Use regression-first tests at the narrowest owned seam plus existing functional routing checks. Assert statuses,
headers where applicable, safe response bodies, and absence of sentinel exception text. Preserve the root smoke
contract and run the final canonical gate; disclose any unverified protocol or failure category.

## Implementation Handoff

[TASK-00010 — Sanitize HTTP Failures](../tasks/00010-TASK.md) covers AC-01 through AC-05 as a regression-first bug
slice, blocked by TASK-00009. It specifies the 400/500 distinction and requires exact safe representations recorded
before repair, with root/routing compatibility evidence.

## Progress

Requirement and TASK split approved; TASK-00010 is authored but not implemented. The earlier comparison demonstrated
message passthrough, not disclosure of a real secret. No exploit, successful regression, or repaired boundary is claimed.
