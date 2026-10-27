#!/bin/sh
# Entrypoint produksi: tunggu DB -> migrasi -> seed ESENSIAL -> cache -> start.
# Seed data contoh (demo) TIDAK pernah dijalankan di sini; itu tugas `./run.sh demo`.
set -e
cd /var/www/html

if [ -z "$APP_KEY" ]; then
    echo "[entrypoint] APP_KEY kosong. Isi APP_KEY di file env (run.sh membuatnya otomatis)." >&2
    exit 1
fi

echo "[entrypoint] Menunggu database ${DB_HOST}:${DB_PORT}..."
tries=0
until php -r 'try { new PDO("mysql:host=".getenv("DB_HOST").";port=".getenv("DB_PORT"), getenv("DB_USERNAME"), getenv("DB_PASSWORD")); exit(0); } catch (Throwable $e) { exit(1); }'; do
    tries=$((tries + 1))
    if [ "$tries" -ge 60 ]; then
        echo "[entrypoint] Database tidak merespon setelah 120 detik." >&2
        exit 1
    fi
    sleep 2
done
echo "[entrypoint] Database siap."

# Volume upload baru kosong: siapkan folder & izin.
mkdir -p storage/app/public storage/framework/sessions storage/framework/views storage/framework/cache storage/logs
chown -R www-data:www-data storage bootstrap/cache

php artisan config:clear
php artisan migrate --force
php artisan db:seed --class=EssentialSeeder --force
php artisan storage:link --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[entrypoint] Start nginx + php-fpm."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
