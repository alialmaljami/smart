#!/bin/sh
echo "start.sh: APP_KEY=$(echo ${APP_KEY:+set} | head -c 20)"
echo "start.sh: PORT=${PORT:-8080}"

# Map Railway MySQL env vars to Laravel DB env vars
export DB_HOST="${DB_HOST:-${MYSQLHOST:-${MYSQL_HOST:-localhost}}}"
export DB_PORT="${DB_PORT:-${MYSQLPORT:-${MYSQL_PORT:-3306}}}"
export DB_DATABASE="${DB_DATABASE:-${MYSQLDATABASE:-${MYSQL_DATABASE:-railway}}}"
export DB_USERNAME="${DB_USERNAME:-${MYSQLUSER:-${MYSQL_USER:-root}}}"
export DB_PASSWORD="${DB_PASSWORD:-${MYSQLPASSWORD:-${MYSQL_PASSWORD:-${MYSQL_ROOT_PASSWORD:-}}}}"

echo "DB_HOST=$DB_HOST"
echo "DB_DATABASE=$DB_DATABASE"
echo "DB_USERNAME=$DB_USERNAME"

php artisan migrate --force 2>&1
php artisan db:seed --force 2>&1 || true

exec php -S 0.0.0.0:8080 -t /app/public /app/server.php
