@echo off
echo ==========================================================
echo DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id
echo ==========================================================

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id
set ARCHIVE=deploy_tmp.tar.gz

echo [1/3] Push update ke GitHub...
git add -A
git commit -m "deploy: update %date% %time%" 2>nul || echo (tidak ada perubahan baru)
git push origin main

echo.
echo [2/3] Buat paket deployment (tar)...
if exist %ARCHIVE% del %ARCHIVE%
tar -czf %ARCHIVE% ^
  --exclude=".git" ^
  --exclude=".github" ^
  --exclude="node_modules" ^
  --exclude="%ARCHIVE%" ^
  --exclude="bootstrap/cache/*.php" ^
  --exclude="public_html/storage" ^
  --exclude="storage/logs" ^
  --exclude="storage/framework/cache" ^
  --exclude="storage/framework/sessions" ^
  --exclude="storage/framework/views" ^
  app bootstrap config database public public_html resources routes storage vendor artisan composer.json 2>nul

echo.
echo [3/3] Upload ^& Deploy ke Hostinger (1x password)...
type %ARCHIVE% | ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "^
  set -e; ^
  cd %REMOTE_DIR% ; ^
  tar -xzf - ; ^
  rm -rf public_html/storage ; ^
  ln -s %REMOTE_DIR%/storage/app/public %REMOTE_DIR%/public_html/storage ; ^
  chmod -R 775 storage bootstrap/cache 2>/dev/null || true ; ^
  php artisan migrate --force 2>&1 ; ^
  php artisan optimize:clear 2>&1 ; ^
  php artisan view:cache 2>&1 ; ^
  echo Deploy selesai!"

if exist %ARCHIVE% del %ARCHIVE%

echo.
echo ==========================================================
echo DEPLOY SELESAI! Website airsegarprigen.hvmdigital.id diperbarui.
echo ==========================================================
pause
