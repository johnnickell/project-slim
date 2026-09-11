# Wayfinder Maps

Wayfinder maps chart an uncertain feature before it becomes an epic, PRD, or implementation ticket. A map is an
index of linked decision tickets, not a second source of decisions. Start with an active map's **Frontier**; when
none is available, offer to chart a new feature.

## Active maps

- [Slim AccessControl Application](slim-access-control-application-map.md) — charts the complete local Docker,
  AccessControl delivery, OpenAPI, Mercure, and independently owned React SPA contract. Current frontier:
  [WF-002 — Local Development Runtime Contract](tickets/WF-002-local-development-runtime-contract.md).

Use `_MAP_TEMPLATE.md` and `tickets/_WAYFINDER_TICKET_TEMPLATE.md` for new work. `research/` holds linked
evidence, never a parallel decision record. Archive only through `../../bin/archive-planning` after a map is Closed,
its decisions are Closed, its frontier is empty, and its implementation handoff is linked.
