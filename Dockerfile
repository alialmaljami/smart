FROM php:8.4-cli

RUN echo "<?php http_response_code(200); echo 'ok';" > /app/index.php

EXPOSE 8080

CMD php -S 0.0.0.0:8080 -t /app
