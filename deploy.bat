@echo off
setlocal EnableDelayedExpansion
echo.
echo ==========================================================
echo  FAST DEPLOY (SUPER KILAT ~3 DETIK): airsegarprigen.hvmdigital.id
echo ==========================================================
echo.

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id
set ARCHIVE=deploy_tmp.tar.gz

:: Hapus tar lama jika ada
if exist %ARCHIVE% (
    del /f /q %ARCHIVE% 2>nul
)

echo [1/4] Push update ke GitHub...
git add app bootstrap config database public_html resources routes storage .env artisan composer.json .gitignore deploy.bat deploy.ps1 deploy_full.bat 2>nul
git commit -m "deploy: %DATE% %TIME%" 2>nul
git push origin main
echo.

echo [2/4] Membuat paket deployment (Kilat - tanpa vendor)...
tar -czf %ARCHIVE% ^
    --exclude=".git" ^
    --exclude=".github" ^
    --exclude="node_modules" ^
    --exclude="vendor" ^
    --exclude="%ARCHIVE%" ^
    --exclude="bootstrap/cache/*.php" ^
    --exclude="public_html/storage" ^
    --exclude="storage/logs/*" ^
    --exclude="storage/framework/cache/*" ^
    --exclude="storage/framework/sessions/*" ^
    --exclude="storage/framework/views/*" ^
    app bootstrap config database public_html resources routes storage artisan composer.json .env

if not exist %ARCHIVE% (
    echo ERROR: Gagal membuat tar archive!
    pause
    exit /b 1
)
echo Paket deploy kilat berhasil dibuat.
echo.

echo [3/4] Upload ke server Hostinger via SCP (masukkan password)...
scp -P %SSH_PORT% %ARCHIVE% %SSH_USER%@%SSH_HOST%:%REMOTE_DIR%/deploy_tmp.tar.gz
if errorlevel 1 (
    echo ERROR: Upload SCP gagal!
    del /f /q %ARCHIVE% 2>nul
    pause
    exit /b 1
)
echo Upload berhasil.
echo.

echo [4/4] Ekstrak, Setup Symlink Storage, Migrate, Seed, & Clear Cache (masukkan password)...
ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% && tar -xzf deploy_tmp.tar.gz --overwrite && rm -f deploy_tmp.tar.gz && rm -rf public && mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/app/public storage/logs bootstrap/cache public_html/css && chmod -R 777 storage bootstrap/cache && cp resources/css/app.css public_html/css/app.css && cd %REMOTE_DIR%/public_html && rm -rf storage app bootstrap config database resources routes vendor scratch artisan composer.json composer.lock .env add_*.php temp_*.php && ln -sfn ../storage/app/public storage && cd %REMOTE_DIR% && php artisan migrate --force && php artisan db:seed --force && php artisan optimize:clear && echo '=== SERVER DEPLOYMENT COMPLETED SUCCESSFULLY ==='"

echo.
del /f /q %ARCHIVE% 2>nul

echo ==========================================================
echo  FAST DEPLOY SELESAI (KILAT & OTOMATIS)!
echo ==========================================================
echo Website: https://airsegarprigen.hvmdigital.id
echo.
pause
endlocal
