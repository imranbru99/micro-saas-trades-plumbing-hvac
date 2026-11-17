# TradeFlow — Micro-SaaS for plumbing, HVAC, and trades
FROM php:8.4-cli-bookworm

LABEL org.opencontainers.image.title="TradeFlow"
LABEL org.opencontainers.image.description="Micro-SaaS for plumbing, HVAC, and trades: dispatch, estimates, invoicing, technician apps, and AI assistants."
LABEL org.opencontainers.image.authors="Imran Ahmed <me@imrandev.bd>"
LABEL org.opencontainers.image.url="https://imrandev.bd"

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo_mysql zip bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && php artisan key:generate --force || true

EXPOSE 8000

HEALTHCHECK --interval=30s --timeout=5s --start-period=40s --retries=3 \
    CMD curl -f http://127.0.0.1:8000/ || exit 1

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
