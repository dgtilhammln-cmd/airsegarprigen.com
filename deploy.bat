@echo off
echo ==========================================================
echo DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id
echo ==========================================================

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id
set ZIP_FILE=deploy_airsegarprigen.zip

echo [1/5] Push update ke GitHub (https://github.com/dgtilhammln-cmd/airsegarprigen.com)...
git push origin main

echo.
echo [2/5] Upload .env file...
scp -P %SSH_PORT% .env %SSH_USER%@%SSH_HOST%:%REMOTE_DIR%/.env

echo.
echo [3/5] Membuat archive ZIP project...
if exist %ZIP_FILE% del %ZIP_FILE%
tar -a -c -f %ZIP_FILE% --exclude=".git" --exclude="node_modules" --exclude=".env" --exclude=".trash" --exclude="bootstrap/cache/*.php" --exclude="public/storage" --exclude="public_html/storage" --exclude="storage/logs/*" --exclude="storage/framework/cache/*" --exclude="storage/framework/sessions/*" --exclude="storage/framework/views/*" *

echo.
echo [4/5] Mengunggah ZIP ke server Hostinger...
scp -P %SSH_PORT% %ZIP_FILE% %SSH_USER%@%SSH_HOST%:%REMOTE_DIR%/%ZIP_FILE%

echo.
echo [5/5] Ekstrak, migrate ^& optimize di server Hostinger...
ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% && rm -rf public_html/storage bootstrap/cache/*.php 2>/dev/null || true && unzip -o %ZIP_FILE% && rm -f %ZIP_FILE% && php artisan storage:link 2>/dev/null || true && php artisan migrate --force && php artisan db:seed --force 2>/dev/null || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && chmod -R 775 storage bootstrap/cache 2>/dev/null || true"

if exist %ZIP_FILE% del %ZIP_FILE%

echo.
echo ==========================================================
echo DEPLOY SELESAI! Website airsegarprigen.hvmdigital.id diperbarui.
echo ==========================================================
pause
