#!/bin/bash
set -e

# Create SQLite database if it doesn't exist
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
    echo "Created SQLite database file."
fi

# Set proper permissions
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chmod 664 /var/www/html/database/database.sqlite

# Clear and cache config
php artisan config:clear
php artisan cache:clear

# Run migrations
php artisan migrate --force

# Start the Laravel server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
