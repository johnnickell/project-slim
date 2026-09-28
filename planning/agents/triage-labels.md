# Triage States

- `needs-triage`: not yet classified.
- `needs-info`: blocked on a decision or missing evidence.
- `ready-for-agent`: requirements may be decomposed; TASKs are executable only when dependencies and execution authority permit.
- `ready-for-human`: requires human judgment or an external action.
- `in-progress`: actively being changed.
- `done`: acceptance criteria and verification are complete.
- `wontfix`: intentionally closed without implementation.

Do not store `blocked` as a status; derive it from unfinished dependency edges.