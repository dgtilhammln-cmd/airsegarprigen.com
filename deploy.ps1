# ============================================================
# AUTOMATIC DEPLOYMENT SCRIPT: airsegarprigen.hvmdigital.id
# ============================================================

$SSH_HOST   = "46.202.186.86"
$SSH_PORT   = "65002"
$SSH_USER   = "u664715641"
$REMOTE_DIR = "/home/u664715641/domains/airsegarprigen.hvmdigital.id"
$ARCHIVE    = "deploy_tmp.tar.gz"

Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host " AUTOMATIC DEPLOYMENT: airsegarprigen.hvmdigital.id" -ForegroundColor Cyan
Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host ""

# 0. Clean old archive
if (Test-Path $ARCHIVE) {
    Remove-Item $ARCHIVE -Force -ErrorAction SilentlyContinue
    Start-Sleep -Seconds 1
}

# 1. Git Push (fast, excludes vendor)
Write-Host "[1/4] Push update ke GitHub..." -ForegroundColor Yellow
git add app bootstrap config database public_html resources routes storage .env artisan composer.json .gitignore deploy.bat deploy.ps1 2>$null
git commit -m "deploy: $(Get-Date -Format 'yyyy-MM-dd HH:mm')" 2>$null
git push origin main
Write-Host ""

# 2. Compress archive
Write-Host "[2/4] Membuat paket deployment (termasuk vendor)..." -ForegroundColor Yellow
& tar -czf $ARCHIVE --exclude=".git" --exclude="node_modules" --exclude="vendor" --exclude=".trash" --exclude="$ARCHIVE" --exclude="bootstrap/cache/*.php" --exclude="public_html/storage" --exclude="storage/logs/*" --exclude="storage/framework/cache/*" --exclude="storage/framework/sessions/*" --exclude="storage/framework/views/*" app bootstrap config database public_html resources routes storage .env artisan composer.json

if (-not (Test-Path $ARCHIVE)) {
    Write-Host "ERROR: Gagal membuat tar archive!" -ForegroundColor Red
    exit 1
}
Write-Host "Paket deploy berhasil dibuat." -ForegroundColor Green
Write-Host ""

# 3. SCP Upload
Write-Host "[3/4] Upload ke Hostinger via SCP (masukkan password)..." -ForegroundColor Yellow
scp -P $SSH_PORT $ARCHIVE "${SSH_USER}@${SSH_HOST}:${REMOTE_DIR}/deploy_tmp.tar.gz"

if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Upload SCP gagal!" -ForegroundColor Red
    Remove-Item $ARCHIVE -Force -ErrorAction SilentlyContinue
    exit 1
}
Write-Host "Upload berhasil." -ForegroundColor Green
Write-Host ""

# 4. SSH Extract, Setup Storage, Migrate, Seed & Optimize
Write-Host "[4/4] Ekstrak, Setup Storage, Migrate, Seed, & Clear Cache di Server (masukkan password)..." -ForegroundColor Yellow
$remoteCmd = "cd $REMOTE_DIR && tar -xzf deploy_tmp.tar.gz --overwrite && rm -f deploy_tmp.tar.gz && rm -rf public && mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/app/public storage/logs bootstrap/cache public_html/css && chmod -R 777 storage bootstrap/cache && cp resources/css/app.css public_html/css/app.css && cd $REMOTE_DIR/public_html && rm -rf storage app bootstrap config database resources routes vendor scratch artisan composer.json composer.lock .env add_*.php temp_*.php && ln -sfn ../storage/app/public storage && cd $REMOTE_DIR && php artisan migrate --force && php artisan db:seed --force && php artisan optimize:clear && echo '=== SERVER DEPLOYMENT COMPLETED SUCCESSFULLY ==='"

ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" $remoteCmd

# Clean local archive safely
if (Test-Path $ARCHIVE) {
    Remove-Item $ARCHIVE -Force -ErrorAction SilentlyContinue
}

Write-Host ""
Write-Host "==========================================================" -ForegroundColor Green
Write-Host " DEPLOY SELESAI & 100% OTOMATIS!" -ForegroundColor Green
Write-Host "==========================================================" -ForegroundColor Green
Write-Host "Website: https://airsegarprigen.hvmdigital.id" -ForegroundColor Green
