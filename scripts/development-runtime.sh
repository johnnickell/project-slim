#!/usr/bin/env sh
# Shared by bin/{up,down,exec,phpunit,composer}; not a standalone command.
set -eu
# Keep identity validation bytewise (locale ranges can otherwise include uppercase letters).
LC_ALL=C
export LC_ALL

runtime_error() {
    printf '%s\n' "$*" >&2
    exit 1
}

# Resolve the physical checkout, not the caller's current working directory or Git common directory.
runtime_root=$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd -P)
cd "$runtime_root"
command -v docker >/dev/null 2>&1 || runtime_error 'Docker is required (including Docker Compose v2).'
docker compose version >/dev/null 2>&1 || runtime_error 'Docker Compose v2 is required.'
docker info >/dev/null 2>&1 || runtime_error 'Docker daemon is unavailable. Start Docker and retry.'
if command -v sha256sum >/dev/null 2>&1; then
    runtime_digest=$(printf '%s' "$runtime_root" | sha256sum)
elif command -v shasum >/dev/null 2>&1; then
    runtime_digest=$(printf '%s' "$runtime_root" | shasum -a 256)
else
    runtime_error 'sha256sum or shasum is required for checkout identity.'
fi
runtime_hash=$(printf '%.16s' "$runtime_digest")
COMPOSE_PROJECT_NAME=${COMPOSE_PROJECT_NAME:-slim-$runtime_hash}
case "$COMPOSE_PROJECT_NAME" in
    [a-z0-9]*) ;;
    *) runtime_error 'COMPOSE_PROJECT_NAME must start with a lowercase letter or digit.' ;;
esac
case "$COMPOSE_PROJECT_NAME" in
    *[!a-z0-9_-]*) runtime_error 'COMPOSE_PROJECT_NAME may contain only lowercase letters, digits, hyphens and underscores.' ;;
esac
PROJECT_SLIM_HTTP_PORT=${PROJECT_SLIM_HTTP_PORT:-0}
case "$PROJECT_SLIM_HTTP_PORT" in
    *[!0-9]*|'') runtime_error 'PROJECT_SLIM_HTTP_PORT must be 0 (automatic) or a port from 1024 to 65535.' ;;
esac
# Bound length before arithmetic and reject ambiguous leading zeros.
if [ "${#PROJECT_SLIM_HTTP_PORT}" -gt 5 ]; then
    runtime_error 'PROJECT_SLIM_HTTP_PORT must be 0 or a port from 1024 to 65535.'
fi
case "$PROJECT_SLIM_HTTP_PORT" in
    0) ;;
    0*) runtime_error 'PROJECT_SLIM_HTTP_PORT must not contain leading zeros.' ;;
    *) [ "$PROJECT_SLIM_HTTP_PORT" -ge 1024 ] && [ "$PROJECT_SLIM_HTTP_PORT" -le 65535 ] ||
        runtime_error 'PROJECT_SLIM_HTTP_PORT must be 0 or a port from 1024 to 65535.' ;;
esac
PROJECT_SLIM_CHECKOUT=$runtime_root
PROJECT_SLIM_RUNTIME_IMAGE=project-slim-dev:$runtime_hash
export COMPOSE_PROJECT_NAME PROJECT_SLIM_HTTP_PORT PROJECT_SLIM_CHECKOUT PROJECT_SLIM_RUNTIME_IMAGE

runtime_compose() {
    # Ignore ambient file/profile selection and implicit .env/override loading.
    COMPOSE_PROFILES= docker compose --project-name "$COMPOSE_PROJECT_NAME" \
        --project-directory "$runtime_root" --env-file /dev/null --file "$runtime_root/compose.yaml" "$@"
}

runtime_check_ownership() {
    # A project-name override must never adopt another checkout's existing resources.
    for runtime_kind in container network volume; do
        case "$runtime_kind" in
            container) runtime_ids=$(docker ps -aq --filter "label=com.docker.compose.project=$COMPOSE_PROJECT_NAME") ;;
            network) runtime_ids=$(docker network ls -q --filter "label=com.docker.compose.project=$COMPOSE_PROJECT_NAME") ;;
            volume) runtime_ids=$(docker volume ls -q --filter "label=com.docker.compose.project=$COMPOSE_PROJECT_NAME") ;;
        esac
        for runtime_id in $runtime_ids; do
            if [ "$runtime_kind" = container ]; then
                runtime_owner=$(docker inspect --format '{{ index .Config.Labels "dev.fight.slim.checkout" }}' "$runtime_id")
            else
                runtime_owner=$(docker "$runtime_kind" inspect --format '{{ index .Labels "dev.fight.slim.checkout" }}' "$runtime_id")
            fi
            [ "$runtime_owner" = "$runtime_root" ] ||
                runtime_error "Refusing project $COMPOSE_PROJECT_NAME: $runtime_kind $runtime_id is not owned by this checkout. Choose a different COMPOSE_PROJECT_NAME; do not remove foreign resources."
        done
    done
}

runtime_require_dependencies() {
    [ -f vendor/autoload.php ] || runtime_error 'Dependencies are not installed. Run: ./bin/composer install --no-interaction --prefer-dist --no-progress'
}

runtime_require_service() {
    runtime_service=$(runtime_compose ps --status running -q web)
    [ -n "$runtime_service" ] || runtime_error 'Development service web is not running for this checkout/project. Run explicit setup if needed, then ./bin/up.'
}

runtime_check_ownership
