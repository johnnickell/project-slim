# Released Package Contract Audit

**Labels:** `wayfinder:research`
**Mode:** AFK
**Status:** Open
**Gate:** Released baseline installed by TASK-00006; complete consumer capability inventory still required
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** —

## Question

What consumer-relevant public capabilities do the qualified released Fight Common and Fight AccessControl
packages expose, and which delivery boundary should intentionally own each capability in the Slim starter?
The 2026-10-24 baseline is Common `v1.4.0` / AccessControl `v0.8.0`; former `v1.2.0` / `v0.2.0` assumptions
are superseded by TASK-00006's released installation, not by a development branch.

## Must decide

- Audit installed release artifacts and public documentation rather than development branches or copied internals.
- Inventory every public command, query, result, event, service, port, value object, policy seam, and composition
  requirement relevant to a consumer.
- Classify every capability as HTTP, CLI/operator, worker/subscriber, or composition-only, with an explicit reason.
- Identify package prerequisites and unsupported or deliberately unexposed capabilities without manufacturing routes.
- Produce traceable evidence that WF-008 can turn into the complete operation matrix.

## Resolution boundary

This ticket establishes the authoritative released-package inventory and boundary classification. It does not choose
endpoint schemas, persistence adapters, security parameters, runtime topology, UI behavior, or implementation work.
Research remains gated until both versions can be installed as releases; a development alias is not release evidence.

## Resolution

Open. TASK-00006's bounded [released baseline](../../../docs/engineering/DEPENDENCIES.md) qualifies existing
composition and retained integration contracts. It does not complete the full command/query/result/event/service
inventory or boundary classification required here. WF-008 still needs that evidence; no product flow or map
closure follows from package installation.
