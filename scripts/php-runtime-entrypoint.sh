#!/usr/bin/env sh
set -eu

php /app/scripts/check-php-runtime.php >&2
exec docker-php-entrypoint "$@"
