FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libsqlite3-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install \
        pdo_sqlite \
        mbstring \
        zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN cd backend \
    && cp .env.example .env \
    && sed -i 's/APP_ENV=local/APP_ENV=production/' .env \
    && sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env \
    && composer install --no-dev --optimize-autoloader --no-interaction \
    && touch database/database.sqlite \
    && php artisan key:generate --force \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD cd backend \
    && sed -i "s|FRONTEND_URL=.*|FRONTEND_URL=https://squarely-technical-case-study.vercel.app|" .env \
    && php artisan config:clear \
    && php artisan migrate --force \
    && php artisan db:seed --force \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
