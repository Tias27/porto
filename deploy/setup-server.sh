#!/usr/bin/env bash
set -euo pipefail

# Jalankan di VPS setelah upload project ke /var/www/porto
# chmod +x deploy/setup-server.sh && sudo bash deploy/setup-server.sh

APP_DIR="/var/www/porto"
WEB_USER="www-data"

cd "$APP_DIR"

if [ ! -f .env ]; then
    cp deploy/env.production.example .env
    echo "Buat .env dari template — edit database & encryption.key dulu!"
    php spark key:generate
fi

composer install --no-dev --optimize-autoloader
php spark migrate --all
php spark db:seed PortfolioSeeder || true

mkdir -p public/uploads/projects public/uploads/cv
chown -R "$WEB_USER:$WEB_USER" writable public/uploads
chmod -R 775 writable public/uploads

echo "Selesai. Pastikan nginx root = $APP_DIR/public"
