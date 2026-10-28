# Local issue tracking

Repository-local EPIC/TICKET/TASK metadata owns scope, status, priority, and dependencies. Requirements are not
executable work; `planning/tickets/BOARD.md` is the one TASK execution view. Current selection summaries are
generated from records. [Land closeout](../CONVENTIONS.md#publication-closeout) owns accepted TASK/current-doc
closure, exact live subject validation and eligible local retirement; no persistent delivery queue or recurring
post-merge planning chore. Routing remains read-only and planning checks stay offline.
Refresh marked sections explicitly
with `./bin/planning-check --write`, then run read-only `./bin/planning-check`; builds never refresh planning. Mark completion only with verified acceptance and a green required gate. Old PRD/T-ticket IDs survive only
as historical prose in migrated records and `planning/MIGRATION.md`, never as parser aliases or a second status system.
