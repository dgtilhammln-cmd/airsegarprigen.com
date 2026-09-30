# ============================================================
# DEPLOY SCRIPT — airsegarprigen.hvmdigital.id
# Cara pakai: .\deploy.ps1 atau ./deploy
# ============================================================

$SSH_HOST   = "46.202.186.86"
$SSH_PORT   = "65002"
$SSH_USER   = "u664715641"
$REMOTE_DIR = "/home/u664715641/domains/airsegarprigen.hvmdigital.id"
$ZIP_FILE   = "deploy_airsegarprigen.zip"

Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host " DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id" -ForegroundColor Cyan
Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "[1/5] Push update ke GitHub (https://github.com/dgtilhammln-cmd/airsegarprigen.com)..." -ForegroundColor Yellow
git push origin main

Write-Host ""
Write-Host "[2/5] Upload .env file..." -ForegroundColor Yellow
scp -P $SSH_PORT ".env" "${SSH_USER}@${SSH_HOST}:${REMOTE_DIR}/.env"

Write-Host ""
Write-Host "[3/5] Membuat archive ZIP project..." -ForegroundColor Yellow
if (Test-Path $ZIP_FILE) { Remove-Item $ZIP_FILE -Force }
tar -a -c -f $ZIP_FILE --exclude=".git" --exclude="node_modules" --exclude=".env" --exclude="storage/logs/*" --exclude="storage/framework/cache/*" --exclude="storage/framework/sessions/*" --exclude="storage/framework/views/*" *

Write-Host ""
Write-Host "[4/5] Mengunggah ZIP ke server Hostinger..." -ForegroundColor Yellow
scp -P $SSH_PORT $ZIP_FILE "${SSH_USER}@${SSH_HOST}:${REMOTE_DIR}/${ZIP_FILE}"

Write-Host ""
Write-Host "[5/5] Ekstrak, migrate & optimize di server Hostinger..." -ForegroundColor Yellow
$remoteCmd = "cd $REMOTE_DIR && unzip -o $ZIP_FILE && rm $ZIP_FILE && php artisan migrate --force && php artisan db:seed --force 2>/dev/null || true && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && chmod -R 775 storage bootstrap/cache 2>/dev/null || true"
ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" $remoteCmd

if (Test-Path $ZIP_FILE) { Remove-Item $ZIP_FILE -Force }

Write-Host ""
Write-Host "==========================================================" -ForegroundColor Green
Write-Host " DEPLOY SELESAI! Website airsegarprigen.hvmdigital.id diperbarui." -ForegroundColor Green
Write-Host "==========================================================" -ForegroundColor Green
