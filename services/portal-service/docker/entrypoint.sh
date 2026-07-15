#!/bin/sh

set -e

echo "Starting Portal Service..."

mkdir -p storage/logs

chmod -R 775 storage bootstrap/cache

exec php-fpm