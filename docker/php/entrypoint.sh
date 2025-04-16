#!/bin/sh

# Wait until MySQL is ready
# echo "Waiting for MySQL..."
# until mysqladmin ping -h mysql --silent; do
#   sleep 2
# done

# echo "MySQL is up - running Laravel setup..."

# Install dependencies
composer install

# Set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy .env if it doesn't exist
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Generate key and run migrations + seed
php artisan key:generate
php artisan migrate:fresh --seed

# Run PHP-FPM
php-fpm
