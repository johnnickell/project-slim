# AGENTS.md

## Work routing

For “What's next?”, `next`, or an unqualified `/ask-matt`, go straight to the [Board](planning/tickets/BOARD.md)
before general project orientation. Read its current human decision and active work; otherwise select the first
executable ready TASK in Board order. Use the [Wayfinder index](planning/wayfinder/README.md) for map status and current frontier pointers.
Follow [lightweight work routing](planning/CONVENTIONS.md#lightweight-work-routing) for validation,
bounded evidence reads and planning handoffs. Recommend and stop; load execution guidance when work is invoked.
This routing path does not require reading README, architecture, full project context, task history or receiving skills.

## Project guidance

For execution or substantive planning changes, load the applicable guidance below. The read-only routing
path above takes precedence over broad orientation reads; it does not waive engineering or delivery rules.

Read `ARCHITECTURE.md`, `planning/README.md`, `planning/CONVENTIONS.md`, and `planning/agents/` before changing behavior. Work in independently verifiable vertical slices. Use the repository-owned `./bin/build`, `./bin/phpunit`, `./bin/up`, `./bin/down`, `./bin/composer`, and `./bin/exec` commands; `./bin/build` is the single noninteractive local and hosted gate.

Slim owns `src/`, its explicit Fight Common container definitions, routes, middleware, handlers, HTTP, presentation, and future adapters. Fight Common and Fight AccessControl are public Composer dependencies only. Do not implement login, persistence, browser journeys, releases, tags, Packagist publication, template enablement, or create-project distribution without a local ticket.

## Run and Worktree Isolation

Coordinate-build scratch belongs in `.runs/<YYYY-MM-DD>-<slug>/`. It is gitignored and must never be staged.

## Branch Conventions

Create feature branches from `develop` as `feature/<description>`. Never commit directly to `develop` or `main`.

## Pre-Submit Gate

For a long non-interactive build, run `screen -dmS <ticket>-build /bin/zsh -lc './bin/build > /private/tmp/<ticket>-build.log 2>&1; print -r -- $? > /private/tmp/<ticket>-build.exit'`, then inspect the log and require an exit file containing `0`; never treat foreground timeout output as a build result.

Always run before committing or creating a PR:

```bash
./bin/build
```

## Planning

See `planning/CONVENTIONS.md` for the canonical planning structure: ticket lifecycle, BOARD.md execution frontier,
Wayfinder maps, EPIC/TICKET/TASK conventions, file naming, templates, and explicit-only archive operations. Old IDs
are provenance only; see `planning/MIGRATION.md`. Never archive as a completion side effect. `./bin/archive-planning`
is disabled pending TASK-00002; once implemented, require an explicit request and review the dry run before apply.

### Pre-PR Sync Checklist

Before final commit and PR for any feature or bug fix:

1. Mark the implementation TASK `done` only with verified acceptance criteria; only EPIC → TICKET → TASK is supported, and old IDs are provenance, not executable aliases
2. Reflect that implementation outcome in `planning/tickets/BOARD.md` during the documented planning transition
3. Recalculate the "What's Next?" contract if dependencies shifted
4. Update parent TICKET and EPIC progress sections
5. Update `ROADMAP.md` if strategic progress changed
6. Verify completed dependency edges are no longer treated as unresolved blockers; retain those edges as history
7. Run read-only `./bin/planning-check`; `--write`/generated drift checks are deferred to TASK-00002. Do not commit or publish with a failing required gate

When completing a TASK, apply [Automatic parent completion](planning/CONVENTIONS.md#automatic-parent-completion)
in the same operation; do not leave a separate parent assessment or closeout action for the user.

## Certification retirement

Test owned application behavior and meaningful package integrations. Do not create or restore framework-support
certification files, receipt readers/generators, dependency certification matrices, or tests of those mechanisms.
Validate build, configuration and planning tools directly with their owning commands, outside product suites.
Historical certification notes remain history, not current gates.
