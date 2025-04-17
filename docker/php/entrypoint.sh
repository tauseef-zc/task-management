#!/bin/sh

# Install dependencies
composer install

# Set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy .env if it doesn't exist
if [ ! -f .env ]; then
  cp .env.example .env
  cp .env.example .env.testing
fi

# Clear config and cache
echo "Clearing config and cache..."
php artisan config:clear
php artisan cache:clear

# Generate key and run migrations + seed
echo "Generating application key and running migrations..."
php artisan key:generate
php artisan migrate:fresh --seed

# Set up storage link
echo "Setting up storage link..."
php artisan storage:link

# Run tests
echo "Running tests..."
php artisan test

# Set up queue worker
echo "Setting up queue worker..."
php artisan queue:work --daemon --queue=default --sleep=3 --tries=3 &

# Set up scheduler
echo "Setting up scheduler..."
php artisan schedule:run --verbose --no-interaction &

# Run PHP-FPM
php-fpm
