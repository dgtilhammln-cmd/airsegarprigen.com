@echo off
echo ==========================================================
echo DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id (1x Password)
echo ==========================================================

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id
set ARCHIVE=deploy_tmp.tar.gz

echo [1/3] Push update ke GitHub...
git push origin main

echo.
echo [2/3] Kompresi paket deployment...
if exist %ARCHIVE% del %ARCHIVE%
tar -czf %ARCHIVE% --exclude=".git" --exclude="node_modules" --exclude=".trash" --exclude="%ARCHIVE%" --exclude="bootstrap/cache/*.php" --exclude="public/storage" --exclude="public_html/storage" --exclude="storage/logs/*" --exclude="storage/framework/cache/*" --exclude="storage/framework/sessions/*" --exclude="storage/framework/views/*" app bootstrap config database public public_html resources routes storage vendor .env artisan composer.json 2>nul

echo.
echo [3/3] Upload ^& Deploy ke Hostinger (DIMINTA PASSWORD 1x SAJA)...
type %ARCHIVE% | ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% && rm -f public_html/storage bootstrap/cache/*.php 2>/dev/null || true && tar -xzf - && php artisan storage:link 2>/dev/null || true && php artisan migrate --force && php artisan db:seed --force 2>/dev/null || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && chmod -R 775 storage bootstrap/cache 2>/dev/null || true"

if exist %ARCHIVE% del %ARCHIVE%

echo.
echo ==========================================================
echo DEPLOY SELESAI! Website airsegarprigen.hvmdigital.id diperbarui.
echo ==========================================================
pause
