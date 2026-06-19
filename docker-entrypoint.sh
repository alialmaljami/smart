#!/bin/sh
set -e

echo "Waiting for MySQL..."
max_tries=30
try=0
until php -r "new PDO('mysql:host=${DB_HOST:-mysql.railway.internal};port=${DB_PORT:-3306};dbname=${DB_DATABASE:-railway}', '${DB_USERNAME:-root}', '${DB_PASSWORD:-}', [PDO::ATTR_TIMEOUT=>3]);" 2>/dev/null; do
    try=$((try+1))
    if [ $try -ge $max_tries ]; then
        echo "MySQL not ready after $max_tries tries, continuing anyway..."
        break
    fi
    echo "MySQL not ready yet (attempt $try/$max_tries)..."
    sleep 2
done

echo "Running migrations..."
php artisan migrate --force --isolated || echo "Migration failed, continuing..."

echo "Starting server on 0.0.0.0:${PORT:-80}..."
exec php -S 0.0.0.0:${PORT:-80} -t public
