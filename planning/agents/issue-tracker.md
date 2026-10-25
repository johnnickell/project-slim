# Local issue tracking

Repository-local EPIC/TICKET/TASK metadata owns scope, status, priority, and dependencies. Requirements are not
executable work; `planning/tickets/BOARD.md` is the one TASK execution view. Current selection/delivery summaries
are generated from records. Routing runs `./bin/planning-check --check-delivery` read-only; authorized
Work/planning/Land intake runs `--reconcile-delivery` before record edits under
[the delivery contract](../CONVENTIONS.md#current-delivery-handoffs), with no new routine cleanup approval.
Refresh marked sections explicitly
with `./bin/planning-check --write`, then run read-only `./bin/planning-check`; builds never refresh planning. Mark completion only with verified acceptance and a green required gate. Old PRD/T-ticket IDs survive only
as historical prose in migrated records and `planning/MIGRATION.md`, never as parser aliases or a second status system.
