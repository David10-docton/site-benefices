#!/bin/bash
cd /var/www/html

# Permissions storage
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

# Migrations
php artisan migrate --force

# Vider les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Reconstruire les caches
php artisan config:cache
php artisan route:cache

# Démarrer Apache
apache2-foreground