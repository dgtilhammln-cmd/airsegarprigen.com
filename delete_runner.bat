@echo off
echo Menghapus artisan_runner.php dari server (security)...
ssh -p 65002 u664715641@46.202.186.86 "rm -f /home/u664715641/domains/airsegarprigen.hvmdigital.id/public_html/artisan_runner.php && echo DELETED"
echo.
echo File runner sudah dihapus dari server.
pause
