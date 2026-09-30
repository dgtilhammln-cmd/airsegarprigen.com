@echo off
echo ==========================================================
echo DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id (Direct public_html)
echo ==========================================================

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id/public_html

echo [1/2] Push update ke GitHub...
git push origin main

echo.
echo [2/2] Stream sync ^& deploy langsung ke public_html Hostinger (1x PASSWORD)...
tar -c --exclude=".git" --exclude="node_modules" --exclude=".trash" --exclude="bootstrap/cache/*.php" --exclude="public/storage" --exclude="public_html/storage" --exclude="storage/logs/*" --exclude="storage/framework/cache/*" --exclude="storage/framework/sessions/*" --exclude="storage/framework/views/*" * .env | ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% && rm -rf bootstrap/cache/*.php 2>/dev/null || true && tar -x && cp -rn public_html/* . 2>/dev/null || true && php artisan storage:link 2>/dev/null || true && php artisan migrate --force && php artisan db:seed --force 2>/dev/null || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && chmod -R 775 storage bootstrap/cache 2>/dev/null || true"

echo.
echo ==========================================================
echo DEPLOY SELESAI! Website airsegarprigen.hvmdigital.id diperbarui.
echo ==========================================================
pause
