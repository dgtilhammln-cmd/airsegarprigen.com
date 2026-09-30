# ============================================================
# DEPLOY SCRIPT — PT Biner (ptbinercoid.hvmdigital.id)
# Cara pakai: .\deploy.ps1
# Pastikan setup_github_ssh.ps1 sudah dijalankan sebelumnya!
# ============================================================

$SSH_HOST   = "46.202.186.86"
$SSH_PORT   = "65002"
$SSH_USER   = "u664715641"
$REMOTE_DIR = "/home/u664715641/domains/ptbinercoid.hvmdigital.id"

Write-Host "========================================" -ForegroundColor Cyan
Write-Host " DEPLOY PT BINER — ptbinercoid.hvmdigital.id" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Upload .env ke server
Write-Host "[1/2] Upload file .env..." -ForegroundColor Yellow
& scp -P $SSH_PORT ".env" "${SSH_USER}@${SSH_HOST}:${REMOTE_DIR}/.env"

Write-Host ""
Write-Host "[2/2] Deploy via Git + Artisan..." -ForegroundColor Yellow

# Script bash yang dijalankan di server
$script = "cd $REMOTE_DIR && " +
    "git fetch origin && " +
    "git reset --hard origin/main && " +
    "composer install --no-dev --optimize-autoloader --quiet && " +
    "php artisan migrate --force && " +
    "php artisan optimize:clear && " +
    "php artisan config:cache && " +
    "php artisan view:cache && " +
    "chmod -R 775 storage bootstrap/cache && " +
    "echo 'DEPLOY SELESAI!'"

& ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" $script

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host " Deploy selesai!" -ForegroundColor Green
Write-Host " Cek: https://ptbinercoid.hvmdigital.id" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
