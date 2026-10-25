FROM php:8.5.12-cli-bookworm

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install --no-install-recommends --yes git python3 unzip && rm -rf /var/lib/apt/lists/*
RUN pecl install pcov-1.0.12 && docker-php-ext-enable pcov
COPY etc/docker/cli/runtime-security.ini /usr/local/etc/php/conf.d/zz-runtime-security.ini
COPY scripts/check-php-runtime.php /app/scripts/check-php-runtime.php
COPY --chmod=755 scripts/php-runtime-entrypoint.sh /usr/local/bin/project-slim-entrypoint
RUN php /app/scripts/check-php-runtime.php
ENTRYPOINT ["project-slim-entrypoint"]
WORKDIR /app
