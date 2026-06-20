#!/bin/sh
echo "start.sh: APP_KEY=$(echo ${APP_KEY:+set} | head -c 20)"
echo "start.sh: PORT=${PORT:-8080}"

# Debug: show all Railway MySQL vars
echo "--- Railway MySQL vars ---"
echo "MYSQLHOST=$MYSQLHOST"
echo "MYSQLPORT=$MYSQLPORT"
echo "MYSQLUSER=$MYSQLUSER"
echo "MYSQLPASSWORD=${MYSQLPASSWORD:+set}"
echo "MYSQLDATABASE=$MYSQLDATABASE"
echo "MYSQL_URL=$MYSQL_URL"
echo "MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:+set}"
echo "---  end  ---"

# Write .env file from Railway env
cat > /app/.env << EOF
APP_KEY=${APP_KEY:-}
APP_ENV=${APP_ENV:-production}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://smart-production-7f5e.up.railway.app}

DB_CONNECTION=mysql
DB_HOST=${DB_HOST:-mysql.railway.internal}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-railway}
DB_USERNAME=${DB_USERNAME:-root}
DB_PASSWORD=${DB_PASSWORD:-}

EOF

echo "--- .env file ---"
cat /app/.env
echo "---  end  ---"

php artisan migrate --force 2>&1
php artisan db:seed --force 2>&1 || true

exec php -S 0.0.0.0:8080 -t /app/public /app/server.php
