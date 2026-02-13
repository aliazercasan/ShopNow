#!/bin/bash

echo "🚀 Running post-deployment tasks..."

# Run migrations
echo "📦 Running migrations..."
php artisan migrate --force

# Check if database is empty (no users exist)
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();")

if [ "$USER_COUNT" -eq "0" ]; then
    echo "📊 Database is empty. Seeding with dummy data..."
    php artisan db:seed --force
    echo "✅ Database seeded successfully!"
else
    echo "ℹ️  Database already has data. Skipping seeding."
fi

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Post-deployment tasks completed!"
