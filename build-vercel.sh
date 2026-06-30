#!/bin/bash

# Complete Vercel build script for Laravel + Vite application

set -euo pipefail

echo "🚀 Starting Vercel build process..."

#!/bin/bash
# Complete Vercel build script for Laravel + Vite application
set -euo pipefail

echo "🚀 Starting Vercel build process..."

# Step1: Install Node dependencies
echo "📦 Installing Node dependencies..."

# Step2: Install PHP dependencies using local composer if available, otherwise skip
echo "📦 Installing PHP dependencies..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader
else
    echo "⚠️ composer command not found, skipping PHP dependency installation"
fi
npm install

# Step3: Update browser data to fix warnings
echo "🌐 Updating browser data..."
npx update-browserslist-db@latest
npm install baseline-browser-mapping@latest --save-dev

# Step 4: Setup Laravel environment
echo "⚙️  Setting up Laravel..."
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate application key
php artisan key:generate --force

# Step 5: Run database migrations
echo "🗃️  Running database migrations..."
php artisan migrate --force

# Step 6: Build frontend assets
echo "🎨 Building frontend assets..."
npm run build

# Step 7: Optimize Laravel
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed successfully!"
echo "📍 Output directory: public"