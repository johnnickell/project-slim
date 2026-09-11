# Released Package Contract Audit

**Labels:** `wayfinder:research`
**Mode:** AFK
**Status:** Open
**Gate:** Installable Fight Common 1.2.0 and Fight AccessControl 0.2.0
**Map:** [Slim AccessControl Application](../slim-access-control-application-map.md)
**Depends on:** —

## Question

What consumer-relevant public capabilities do the released Fight Common `v1.2.0` and Fight AccessControl `v0.2.0`
packages expose, and which delivery boundary should intentionally own each capability in the Slim starter?

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

Open.
