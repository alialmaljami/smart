#!/bin/sh
# Set APP_KEY if missing (needed for Laravel to boot)
if [ -z "$APP_KEY" ]; then
    echo "WARNING: APP_KEY not set. Generating temporary key..."
    export APP_KEY=$(php -r 'echo "base64:" . base64_encode(random_bytes(32));')
fi

# Start the server
exec php -S 0.0.0.0:8080 -t /app/public /app/server.php
