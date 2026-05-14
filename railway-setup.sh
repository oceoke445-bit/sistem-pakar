#!/bin/bash

# Railway Setup Script - Run this ONCE after first deployment
# This will generate APP_KEY and setup the application

echo "🚀 Railway Setup Script"
echo "======================="

# 1. Create required directories
echo "📁 Creating required directories..."
mkdir -p bootstrap/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs

# 2. Set permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

# 3. Generate APP_KEY
echo "🔑 Generating APP_KEY..."
php artisan key:generate --force --show

echo ""
echo "⚠️  IMPORTANT: Copy the key above and add it to Railway environment variables:"
echo "   Variable name: APP_KEY"
echo "   Variable value: base64:xxxxx (the full key shown above)"
echo ""
echo "After adding APP_KEY to Railway, restart the deployment."
echo ""

# 4. Install dependencies
echo "📦 Installing dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# 5. Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 6. Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# 7. Seed database (optional)
read -p "Do you want to seed the database? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    echo "🌱 Seeding database..."
    php artisan db:seed --force
fi

echo ""
echo "✅ Setup complete!"
echo ""
echo "Next steps:"
echo "1. Make sure APP_KEY is set in Railway environment variables"
echo "2. Restart your Railway deployment"
echo "3. Your app should now work!"
