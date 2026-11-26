#!/bin/sh
# Starts the portal with PHP's built-in web server (no Apache/nginx needed).
# Usage: ./start-server.sh [port]   (default 8080)
cd "$(dirname "$0")" && PHP_CLI_SERVER_WORKERS=4 exec php -S 0.0.0.0:${1:-8080} -t public dev/router.php
