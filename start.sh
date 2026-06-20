#!/bin/sh
echo "start.sh: APP_KEY=$(echo ${APP_KEY:+set} | head -c 20)"
echo "start.sh: PORT=${PORT:-8080}"

exec php -S 0.0.0.0:8080 -t /app/public /app/server.php
