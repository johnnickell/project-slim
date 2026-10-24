# Wayfinder Maps

Wayfinder maps chart an uncertain feature before it becomes an EPIC, requirement TICKETs, and implementation TASKs. A map is an
index of linked decision tickets, not a second source of decisions. Start with an active map's **Frontier**; when
none is available, offer to chart a new feature.

## Active maps

- [Slim AccessControl Application](slim-access-control-application-map.md) — charts the complete local Docker,
  AccessControl delivery, OpenAPI, Mercure, and independently owned React SPA contract. Current frontier:
  [WF-002 — Local Development Runtime Contract](tickets/WF-002-local-development-runtime-contract.md), open but
  paused pending Fight Agent OS direction on shared resources, worktree test isolation, and ingress integration.

Use `_MAP_TEMPLATE.md` and `tickets/_WAYFINDER_TICKET_TEMPLATE.md` for new work. `research/` holds linked
evidence, never a parallel decision record. Archive only on an explicit request after a map is Closed, its decisions
are Closed, its frontier is empty, and its implementation handoff is linked. The owning `../../bin/archive-planning`
command keeps Wayfinder eligibility separate from EPIC/TICKET/TASK. Review its dry run before explicit
`--apply --confirm DIGEST`; see [archive rules](../CONVENTIONS.md#archive-explicit-requests-only).
TASK-00002 does not exercise archive apply or change this map's status/frontier. Do not move records manually.
