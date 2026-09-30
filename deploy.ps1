# ============================================================
# DEPLOY SCRIPT — airsegarprigen.hvmdigital.id (1x Password Input)
# Cara pakai: .\deploy.ps1 atau ./deploy
# ============================================================

$SSH_HOST   = "46.202.186.86"
$SSH_PORT   = "65002"
$SSH_USER   = "u664715641"
$REMOTE_DIR = "/home/u664715641/domains/airsegarprigen.hvmdigital.id"

Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host " DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id" -ForegroundColor Cyan
Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "[1/2] Push update ke GitHub..." -ForegroundColor Yellow
git push origin main

Write-Host ""
Write-Host "[2/2] Stream sync & deploy ke Hostinger (MINTA PASSWORD 1x SAJA)..." -ForegroundColor Yellow

$remoteScript = "cd $REMOTE_DIR && rm -rf public_html/storage bootstrap/cache/*.php 2>/dev/null || true && tar -x && php artisan storage:link 2>/dev/null || true && php artisan migrate --force && php artisan db:seed --force 2>/dev/null || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && chmod -R 775 storage bootstrap/cache 2>/dev/null || true"

& tar -c --exclude=".git" --exclude="node_modules" --exclude=".trash" --exclude="bootstrap/cache/*.php" --exclude="public/storage" --exclude="public_html/storage" --exclude="storage/logs/*" --exclude="storage/framework/cache/*" --exclude="storage/framework/sessions/*" --exclude="storage/framework/views/*" * .env | & ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" $remoteScript

Write-Host ""
Write-Host "==========================================================" -ForegroundColor Green
Write-Host " DEPLOY SELESAI! Website airsegarprigen.hvmdigital.id diperbarui." -ForegroundColor Green
Write-Host "==========================================================" -ForegroundColor Green
