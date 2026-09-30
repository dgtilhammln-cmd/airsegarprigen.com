@echo off
setlocal

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id
set ARCHIVE=deploy_tmp.tar.gz

echo ==========================================================
echo  DEPLOYMENT: airsegarprigen.hvmdigital.id
echo ==========================================================

echo.
echo [1/4] Push ke GitHub...
git add -A
git commit -m "deploy: %DATE% %TIME%" 2>nul
git push origin main

echo.
echo [2/4] Buat paket tar...
if exist %ARCHIVE% del /f /q %ARCHIVE%
tar -czf %ARCHIVE% --exclude=".git" --exclude=".github" --exclude="node_modules" --exclude="deploy_tmp.tar.gz" --exclude="bootstrap/cache" --exclude="public_html/storage" --exclude="storage/logs" --exclude="storage/framework/cache" --exclude="storage/framework/sessions" --exclude="storage/framework/views" app bootstrap config database public public_html resources routes storage vendor artisan composer.json
echo Tar selesai: %ARCHIVE%

echo.
echo [3/4] Upload via SCP (masukkan password)...
scp -P %SSH_PORT% %ARCHIVE% %SSH_USER%@%SSH_HOST%:%REMOTE_DIR%/

echo.
echo [4/4] Ekstrak di server (masukkan password)...
ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% ; tar -xzf deploy_tmp.tar.gz ; rm -f deploy_tmp.tar.gz ; rm -rf public_html/storage ; ln -sf %REMOTE_DIR%/storage/app/public %REMOTE_DIR%/public_html/storage ; chmod -R 775 storage bootstrap/cache ; echo DONE"

echo.
if exist %ARCHIVE% del /f /q %ARCHIVE%

echo ==========================================================
echo  DEPLOY SELESAI!
echo ==========================================================
echo.
echo Sekarang buka browser untuk migrate + seed:
echo https://airsegarprigen.hvmdigital.id/deploy-setup-AirSegar2026?token=AirSegar2026!Deploy^&action=full
echo.
pause
endlocal
