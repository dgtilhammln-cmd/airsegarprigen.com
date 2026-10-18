@echo off
setlocal EnableDelayedExpansion
echo.
echo ==========================================================
echo  DEPLOY via SSH Git Pull: airsegarprigen.hvmdigital.id
echo ==========================================================
echo.

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/airsegarprigen.hvmdigital.id

echo [1/2] Push update ke GitHub...
git add -A
git commit -m "deploy: %DATE% %TIME%" 2>nul
git push origin main
echo.

echo [2/2] SSH ke server: git pull + clear cache...
echo Masukkan password SSH Hostinger:
ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% && git pull origin main && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && php artisan migrate --force && echo === DEPLOY SELESAI ==="
if errorlevel 1 (
    echo ERROR: SSH gagal.
) else (
    echo *** DEPLOY BERHASIL! ***
)
pause
