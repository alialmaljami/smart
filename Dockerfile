FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first so dependency installation is cached
# independently of application code changes
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-autoloader

# Copy the full application now that dependencies are installed
COPY . .

# Generate the optimised autoloader and run post-install scripts
RUN composer dump-autoload --no-dev --optimize \
    && php artisan storage:link

EXPOSE 8080

RUN chmod +x /app/start.sh

CMD ["/app/start.sh"]
