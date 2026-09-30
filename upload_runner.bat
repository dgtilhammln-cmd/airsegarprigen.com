@echo off
echo Upload artisan_runner.php ke server...
scp -P 65002 public_html\artisan_runner.php u664715641@46.202.186.86:/home/u664715641/domains/airsegarprigen.hvmdigital.id/public_html/artisan_runner.php
echo.
echo Upload selesai! Buka URL ini di browser:
echo.
echo   MIGRATE + SEED (full):
echo   https://airsegarprigen.hvmdigital.id/artisan_runner.php?token=AirSegar2026Deploy^&action=full
echo.
echo   Hanya migrate:
echo   https://airsegarprigen.hvmdigital.id/artisan_runner.php?token=AirSegar2026Deploy^&action=migrate
echo.
echo   Hanya seed:
echo   https://airsegarprigen.hvmdigital.id/artisan_runner.php?token=AirSegar2026Deploy^&action=seed
echo.
echo PENTING: Hapus file runner setelah selesai! Jalankan delete_runner.bat
pause
