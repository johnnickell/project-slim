# Shared Pi workflows in Slim

## Provider and target

Use the installed Fight Agent OS skill suite and Pi harness as shared provider resources. Resolve the owning skill
from Pi's supplied resource path; resolve its Markdown/script references relative to that skill, never this checkout.
The invocation checkout is the target. Matching TASK IDs in different repositories do not establish identity.
Do not copy skills, invent installation paths, create symlinks, change global settings or enroll a project to run work.
Missing shared resources hold only the affected workflow with an explicit prerequisite.

The provider's `docs/engineering/PROJECT_CONTEXT.md`, `EXECUTION.md`, `REVIEW.md`, `QA.md`,
`QA_REPORT_TEMPLATE.md`, `LANDING.md`, `HANDOFFS.md` and applicable `QUALITY.md` sections supply shared process and
report definitions. Apply the substitutions below throughout their nested references and delegated role requests.
Local accepted requirements and gates prevail over provider application examples.

## Slim substitutions

| Shared reference | Slim authority |
| --- | --- |
| Target instructions/profile/context | `AGENTS.md`, this binding, `planning/CONVENTIONS.md`, `planning/agents/` |
| Board | `planning/tickets/BOARD.md`, not `planning/tasks/BOARD.md` |
| Foundation | `ARCHITECTURE.md` and `planning/epics/00001-EPIC.md`; no required `planning/FOUNDATION.md` |
| Technical standards/ownership | `docs/engineering/STANDARDS.md` and `planning/adr/0001-application-ownership-and-orchestration.md` |
| Record templates and ID allocation | Target `planning/{epics,tickets,tasks}/` templates, live/archive inventory and `planning/MIGRATION.md` |
| Planning refresh | Until TASK-00002 lands, manually update indexes/Board/Roadmap and run read-only `./bin/planning-check`; never invoke unsupported `--write` |
| Parent completion | Apply local bottom-up automatic parent completion in the same change; preserve terminal/archived parents and historical dependency edges |
| Branch and checkout | Selected checkout, `feature/<description>` from `develop`; preserve an authorized existing branch |
| Runtime/gates | Target `./bin/*` wrappers and current `./bin/build`; do not invoke provider services, database resets or frontend builds |
| Hosted verification | Preserve each explicit target criterion, including TASK-00009/TICKET-00011/EPIC-00001; missing required proof is Unverified |
| PR body | No repository PR template currently exists; include TASK, scope, checks, review/QA provenance, risks and applicable evidence |
| Product/runtime examples | No Agent OS domain, PostgreSQL, managed agents or frontend/authentication claims; follow local product tickets |

Generated views and archive implementation are still TASK-00002 work. Shared `grill`, `to-tickets`, `to-tasks`,
`wayfinder`, `work` and `land` instructions to refresh generated views use the transitional substitution above.
Do not treat a nonexistent automation feature as a dependency for authoring accepted requirements/tasks.

## Scratch and canonical evidence

Adopt shared paths beneath ignored `.runs/`; these supersede the old date-slug-only coordinate-build convention:

- Build ledger/lock/attempts: `<base>/.runs/build/<TASK-ID>/`.
- Work scratch: `.runs/tasks/<TASK-ID>/runs/` in the selected checkout or canonical base.
- Independent review: `<base>/.runs/reviews/<TASK-ID>/review.md`.
- Independent QA: `<base>/.runs/qa/<TASK-ID>/qa.md`, with captures/run history beside it.
- Scoped exploratory evidence: `.runs/notes/<subject>/` or `.runs/prototypes/<subject>/`.

Resolve canonical base via Git common-directory and registered-worktree metadata, not a hardcoded path. Keep
canonical reports outside disposable worktrees. Preserve all historical evidence, including old date-slug runs;
do not reorganize or reset another owner's ledger. All scratch is ignored and must never be staged.

## Review, QA and delivery

Use `work → independent review → applicable QA → authorized land → human merge`.
A material contributor cannot independently accept their implementation or QA it. Work records outcome evidence
and stops before publication. Review and QA may write their own reports, not source/planning fixes or each other's
verdicts. Build coordinates fresh role sessions; it does not issue their independent conclusions.

Review adopts the provider's version-3 report and stable Spec SP-01–SP-05 / Standards ST-01–ST-05 criteria. Map every
TASK criterion to exact evidence, with Pass/Fail/Unverified/justified N/A. Include TASK/repository, branch, full
base/head OIDs, dirty-file identity/digests when applicable, reviewer involvement, findings/severity, commands,
fresh/inherited results, warnings, limitations and accept/revise. All applicable criteria must pass for acceptance.
Use version-2 reports only when their subject and evidence match; never select an older pass over current findings.

Publish complete canonical reports atomically and read them back. Missing/unreadable/stale/non-independent reports
hold publication; green tests or chat assertions are not substitutes. Changed OIDs alone do not invalidate review:
land may prove a mechanical reconciliation with old/new identity, effective diff/range-diff and fresh verification.
Changed behavior or uncertain interaction needs renewed independent review. Never rewrite old acceptance evidence.

QA uses the shared report template and PASS/FAIL/INCOMPLETE/N/A dispositions. Assess changed non-UI behavior and
executable instructions as well as UI. Use real API/library/CLI behavior where present; label instruction walkthroughs
as walkthroughs. Missing runtime/capture prerequisites remain INCOMPLETE. Only actual visual changes require visual
proof; do not invent screenshots for prose. QA reports defects without repairing them or publishing captures.

Local TASK `done` means implemented with all required acceptance verification; it does not imply independent review,
QA, publication, merge, archive, release or deployment. Preserve these facts separately. Required hosted acceptance
must exist before completion; accepted-candidate/final-delivery distinctions require an explicit target contract.
Land may use the shared draft-evidence route only for missing explicitly required hosted proof within publication
authority, preserving incomplete status and resources. Do not weaken a hosted criterion to avoid that handoff.

An explicit `/skill:build TASK-NNNNN` delegates its documented work/review/QA/land and non-force push/open-PR effects;
`next`, a planning interview or an implementation-only request does not. Neither Build nor land grants merge,
force-push, releases, infrastructure enrollment, unrelated cleanup or another TASK. Preserve model pins, original
repair allowance and outstanding effects on resume. Cleanup touches only ownership-proven disposable resources.

## Routing and Pi compatibility

For `next`, use only the root routing entry and the local lightweight convention; do not preload this execution
binding. `next` and `build` are explicit-only skills (`disable-model-invocation: true`); absence from automatic skill
metadata is expected. Verify availability from the installed resource/binding before recommending a command.
Return all active TASKs, otherwise the first ready TASK, plus independent available map frontiers and human inputs.
Unknown/stale evidence requires its owner's reconciliation, not a guessed acceptance or execution stage.

Ordinary native Pi reads/writes/edits/shell require no Jev enrollment. Optional discovery is not a sandbox, and role
metadata is not source-change authority. Do not activate the separate deterministic exact-script policy for Build:
it does not support unrestricted delivery shell/child launch. Runtime upgrades require the provider's compatibility
checks/full restart, not automatic reenrollment, credentials, ledger resets or settings changes.

Before delegating, record the resolved target/provider paths, local substitutions, checkout, gates and completion
policy in the ignored project-context ledger and pass it to every fresh role. Child models and launch support need
actual qualification; an installed package/version or this document alone does not prove end-to-end delivery.
