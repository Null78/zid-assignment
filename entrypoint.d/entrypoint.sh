#!/bin/bash

# Install dependencies
[ ! -d "./vendor" ] && composer install --no-interaction --optimize-autoloader --no-dev

# Optimizing configuration loading
php artisan config:cache
# Optimizing route loading
php artisan route:cache

# Setup log file
[ ! -f "./storage/logs/laravel.log" ] && touch storage/logs/laravel.log

# Setup permissions
chown -R application:application .
chmod -R g+rwx storage bootstrap/cache

# Migrate database
php artisan migrate