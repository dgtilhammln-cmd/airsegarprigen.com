@echo off
echo ==========================================================
echo MIGRATE + SEED: airsegarprigen.hvmdigital.id
echo ==========================================================
echo.
echo Masukkan password SSH Hostinger ketika diminta...
echo.

ssh -p 65002 -t u664715641@46.202.186.86 "cd /home/u664715641/domains/airsegarprigen.hvmdigital.id && echo '--- PHP version ---' && php -v && echo '' && echo '--- Running migrate ---' && php artisan migrate --force 2>&1 && echo '' && echo '--- Running seed ---' && php artisan db:seed --force 2>&1 && echo '' && echo '--- Clearing cache ---' && php artisan optimize:clear 2>&1 && echo '' && echo 'SELESAI!'"

pause
