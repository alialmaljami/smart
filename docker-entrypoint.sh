#!/bin/sh
set -e

echo "[entrypoint] Starting..."
echo "[entrypoint] PORT=${PORT:-not set}"
echo "[entrypoint] APP_KEY=${APP_KEY:+set}"

# Wait for MySQL
echo "[entrypoint] Waiting for MySQL..."
for i in $(seq 1 15); do
  if php -r "new PDO('mysql:host=${DB_HOST:-mysql.railway.internal};port=${DB_PORT:-3306};dbname=${DB_DATABASE:-railway}', '${DB_USERNAME:-root}', '${DB_PASSWORD:-}', [PDO::ATTR_TIMEOUT=>3]);" 2>/dev/null; then
    echo "[entrypoint] MySQL ready."
    break
  fi
  echo "[entrypoint] MySQL not ready (attempt $i)..."
  sleep 2
done

# Run migrations
echo "[entrypoint] Running migrations..."
php artisan migrate --force --isolated 2>&1 || echo "[entrypoint] Migration warning (non-fatal)"

# Cache config
echo "[entrypoint] Caching config..."
php artisan config:cache 2>&1 || true

# Start server
echo "[entrypoint] Starting server on 0.0.0.0:${PORT:-8080}"
exec php -S 0.0.0.0:${PORT:-8080} -t /app/public
