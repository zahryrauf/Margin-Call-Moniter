#!/bin/bash

# Complete Vercel build script for Laravel + Vite application

set -euo pipefail

echo "🚀 Starting Vercel build process..."

# Step 1: Install all dependencies
echo "📦 Installing dependencies..."
npm install
composer install --no-dev --optimize-autoloader

# Step 2: Update browser data to fix warnings
echo "🌐 Updating browser data..."
npx update-browserslist-db@latest
npm install baseline-browser-mapping@latest --save-dev

# Step 3: Setup Laravel environment
echo "⚙️  Setting up Laravel..."
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate application key
php artisan key:generate --force

# Step 4: Run database migrations
echo "🗃️  Running database migrations..."
php artisan migrate --force

# Step 5: Build frontend assets
echo "🎨 Building frontend assets..."
npm run build

# Step 6: Optimize Laravel
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed successfully!"
echo "📍 Output directory: public"