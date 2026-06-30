#!/bin/bash
# Complete Vercel build script for Laravel + Vite application
set -euo pipefail

echo "🚀 Starting Vercel build process..."

# Step1: Install Node dependencies
echo "📦 Installing Node dependencies..."

npm install

# Step2: Update browser data to fix warnings
echo "🌐 Updating browser data..."
npx update-browserslist-db@latest
npm install baseline-browser-mapping@latest --save-dev

# Step3: Build frontend assets
echo "🎨 Building frontend assets..."
npm run build

echo "✅ Build completed successfully!"
echo "📍 Output directory: public"