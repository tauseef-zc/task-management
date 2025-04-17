#!/bin/sh

# Install dependencies
composer install

# Set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy .env if it doesn't exist
if [ ! -f .env ]; then
  cp .env.example .env
fi

php artisan config:clear
php artisan cache:clear

# Generate key and run migrations + seed
php artisan key:generate
php artisan migrate:fresh --seed

# Set up storage link
php artisan storage:link

# Set up queue worker
php artisan queue:work --daemon --queue=default --sleep=3 --tries=3 &

# Set up scheduler
php artisan schedule:run --verbose --no-interaction &

# Run PHP-FPM
php-fpm
