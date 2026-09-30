@echo off
setlocal EnableDelayedExpansion
echo.
echo ==========================================================
echo  AUTOMATIC DEPLOY: airsegarprigen.hvmdigital.id
echo ==========================================================
echo.

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id
set ARCHIVE=deploy_tmp.tar.gz

:: Hapus tar lama jika ada
if exist %ARCHIVE% (
    echo [0/4] Menghapus file temporer lama...
    del /f /q %ARCHIVE% 2>nul
    timeout /t 1 /nobreak >nul
)

echo [1/4] Push update ke GitHub...
git add -A
git commit -m "deploy: %DATE% %TIME%" 2>nul
git push origin main
echo.

echo [2/4] Membuat paket deployment (termasuk vendor lengkap)...
tar -czf %ARCHIVE% ^
    --exclude=".git" ^
    --exclude=".github" ^
    --exclude="node_modules" ^
    --exclude="%ARCHIVE%" ^
    --exclude="bootstrap/cache/*.php" ^
    --exclude="public/storage" ^
    --exclude="public_html/storage" ^
    --exclude="storage/logs/*" ^
    --exclude="storage/framework/cache/*" ^
    --exclude="storage/framework/sessions/*" ^
    --exclude="storage/framework/views/*" ^
    app bootstrap config database public public_html resources routes storage vendor artisan composer.json .env

if not exist %ARCHIVE% (
    echo ERROR: Gagal membuat tar archive!
    pause
    exit /b 1
)
echo Paket deploy berhasil dibuat.
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

echo [4/4] Ekstrak, Migrate, Seed, & Clear Cache di Server (masukkan password)...
ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% && tar -xzf deploy_tmp.tar.gz --overwrite && rm -f deploy_tmp.tar.gz && rm -rf public_html/storage && php artisan storage:link 2>/dev/null || true && php artisan migrate --force && php artisan db:seed --force && php artisan optimize:clear && chmod -R 775 storage bootstrap/cache && echo '=== SERVER DEPLOYMENT COMPLETED SUCCESSFULY ==='"

echo.
del /f /q %ARCHIVE% 2>nul

echo ==========================================================
echo  DEPLOY SELESAI & 100%% OTOMATIS!
echo ==========================================================
echo Website: https://airsegarprigen.hvmdigital.id
echo.
pause
endlocal
