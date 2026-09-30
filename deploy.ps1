# ============================================================
# DEPLOY SCRIPT — airsegarprigen.hvmdigital.id (1x Password Input)
# Cara pakai: .\deploy.ps1 atau ./deploy
# ============================================================

$SSH_HOST   = "46.202.186.86"
$SSH_PORT   = "65002"
$SSH_USER   = "u664715641"
$REMOTE_DIR = "/home/u664715641/domains/airsegarprigen.hvmdigital.id"
$ARCHIVE    = "deploy_tmp.tar.gz"

Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host " DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id" -ForegroundColor Cyan
Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "[1/3] Push update ke GitHub..." -ForegroundColor Yellow
git push origin main

Write-Host ""
Write-Host "[2/3] Kompresi paket deployment..." -ForegroundColor Yellow
if (Test-Path $ARCHIVE) { Remove-Item $ARCHIVE -Force }
& tar -czf $ARCHIVE --exclude=".git" --exclude="node_modules" --exclude=".trash" --exclude="$ARCHIVE" --exclude="bootstrap/cache/*.php" --exclude="public/storage" --exclude="public_html/storage" --exclude="storage/logs/*" --exclude="storage/framework/cache/*" --exclude="storage/framework/sessions/*" --exclude="storage/framework/views/*" app bootstrap config database public public_html resources routes storage vendor .env artisan composer.json 2>$null

Write-Host ""
Write-Host "[3/3] Upload & Deploy ke Hostinger (MINTA PASSWORD 1x SAJA)..." -ForegroundColor Yellow

$remoteScript = "cd $REMOTE_DIR && rm -f public_html/storage bootstrap/cache/*.php 2>/dev/null || true && tar -xzf - && php artisan storage:link 2>/dev/null || true && php artisan migrate --force && php artisan db:seed --force 2>/dev/null || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && chmod -R 775 storage bootstrap/cache 2>/dev/null || true"

cmd /c "type $ARCHIVE | ssh -p $SSH_PORT ${SSH_USER}@${SSH_HOST} `"$remoteScript`""

if (Test-Path $ARCHIVE) { Remove-Item $ARCHIVE -Force }

Write-Host ""
Write-Host "==========================================================" -ForegroundColor Green
Write-Host " DEPLOY SELESAI! Website airsegarprigen.hvmdigital.id diperbarui." -ForegroundColor Green
Write-Host "==========================================================" -ForegroundColor Green
