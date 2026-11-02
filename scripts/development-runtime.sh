#!/usr/bin/env sh
# Shared by focused wrappers; explicit Compose selection lives in bin/runtime.
set -eu
runtime_root=$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd -P)
cd "$runtime_root"
runtime_error() { printf '%s\n' "$*" >&2; exit 1; }
runtime_compose() { "$runtime_root/bin/runtime" docker compose "$@"; }
runtime_require_dependencies() {
    [ -f vendor/autoload.php ] || runtime_error 'Run ./bin/composer install --no-interaction --prefer-dist --no-progress'
}
runtime_require_service() {
    [ -n "$(runtime_compose ps --status running -q web)" ] || runtime_error 'Run ./bin/up --worktree "$PWD" for this checkout first'
}
