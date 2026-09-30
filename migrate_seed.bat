@echo off
echo ==========================================================
echo MIGRATE + SEED: airsegarprigen.hvmdigital.id
echo ==========================================================
echo.
echo Masukkan password SSH Hostinger ketika diminta...
echo.

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE=cd /home/u664715641/domains/airsegarprigen.hvmdigital.id

echo [1/3] Menjalankan php artisan migrate --force ...
ssh -p %SSH_PORT% -o ServerAliveInterval=60 -o ServerAliveCountMax=10 %SSH_USER%@%SSH_HOST% "%REMOTE% && php artisan migrate --force 2>&1 && echo MIGRATE_OK"

echo.
echo [2/3] Menjalankan php artisan db:seed --force ...
ssh -p %SSH_PORT% -o ServerAliveInterval=60 -o ServerAliveCountMax=10 %SSH_USER%@%SSH_HOST% "%REMOTE% && php artisan db:seed --force 2>&1 && echo SEED_OK"

echo.
echo [3/3] Bersihkan cache ...
ssh -p %SSH_PORT% -o ServerAliveInterval=60 -o ServerAliveCountMax=10 %SSH_USER%@%SSH_HOST% "%REMOTE% && php artisan optimize:clear 2>&1 && php artisan storage:link 2>&1 && echo CACHE_OK"

echo.
echo ==========================================================
echo SELESAI!
echo ==========================================================
pause
