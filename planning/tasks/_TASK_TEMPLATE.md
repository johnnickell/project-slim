---
id: TASK-NNNNN
ticket: TICKET-NNNNN
kind: feature
title: Brief independently reviewable outcome
status: needs-triage
order:
blocked_by:
pr:
---

# Brief independently reviewable outcome

## Outcome and Scope

State the bounded implementation outcome, parent acceptance criteria covered, and explicit exclusions.

## Acceptance Criteria

- [ ] **AC-01:** Observable result with evidence.

## Dependencies and Execution

Record true TASK blockers and confirm checkout/worktree choice before implementation. Preserve unrelated work.
For a justified standalone bug/chore, leave `ticket` empty and add a nonempty `standalone_reason` scalar to frontmatter;
a feature always requires a parent TICKET.

## Verification

State focused checks and the canonical `./bin/build` gate. For bugs, reproduce with a failing regression test before
repair when possible; otherwise record why. Validate tooling directly rather than adding product tests of tools.

## Review and Delivery

Record independent Spec/Standards review and the exact reviewed snapshot separately from implementation completion.
Commit, publication, merge, archive, release, and deployment each require their own authority.

## Completion Notes

Record commands, fresh results, counts, warnings, limitations, and the next authorized action only when established.
