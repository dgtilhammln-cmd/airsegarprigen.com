# ============================================================
# SETUP SSH KEY (Jalankan SEKALI SAJA)
# Script ini akan membuat SSH key di server Hostinger dan
# meminta Anda menambahkan key tersebut ke GitHub Deploy Keys
# ============================================================

$SSH_HOST = "46.202.186.86"
$SSH_PORT  = "65002"
$SSH_USER  = "u664715641"

Write-Host "===== SETUP SSH KEY DI HOSTINGER =====" -ForegroundColor Cyan
Write-Host "Langkah ini hanya perlu dijalankan SEKALI saja." -ForegroundColor Yellow
Write-Host ""

# Generate SSH key di server (kalau belum ada)
& ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" @"
if [ ! -f ~/.ssh/id_ed25519 ]; then
    ssh-keygen -t ed25519 -C "hostinger-ptbiner" -f ~/.ssh/id_ed25519 -N ""
    echo "SSH key berhasil dibuat!"
else
    echo "SSH key sudah ada."
fi
echo ""
echo "====== SALIN KEY BERIKUT KE GITHUB ======"
cat ~/.ssh/id_ed25519.pub
echo "========================================="
"@

Write-Host ""
Write-Host "========================================================" -ForegroundColor Yellow
Write-Host "INSTRUKSI SELANJUTNYA (Manual):" -ForegroundColor Yellow
Write-Host "1. Salin SSH public key yang muncul di atas" -ForegroundColor White
Write-Host "2. Buka: https://github.com/dgtilhammln-cmd/ptbiner.co.id/settings/keys" -ForegroundColor White
Write-Host "3. Klik 'Add deploy key'" -ForegroundColor White
Write-Host "4. Paste key tersebut lalu simpan" -ForegroundColor White
Write-Host "5. Setelah itu, jalankan .\setup_github_ssh.ps1 --finish" -ForegroundColor White
Write-Host "========================================================" -ForegroundColor Yellow

# Kalau ada flag --finish, clone repo
if ($args[0] -eq "--finish") {
    Write-Host ""
    Write-Host "=== Melakukan Git Clone ke server ===" -ForegroundColor Cyan

    & ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" @"
cd /home/u664715641/domains/ptbinercoid.hvmdigital.id

# Tambahkan github.com ke known_hosts agar tidak ditanya konfirmasi
ssh-keyscan github.com >> ~/.ssh/known_hosts 2>/dev/null

# Hapus file lama jika ada, lalu clone
rm -rf .git
git clone git@github.com:dgtilhammln-cmd/ptbiner.co.id.git . --branch main

echo "Clone selesai!"
"@

    Write-Host ""
    Write-Host "Sekarang jalankan: .\deploy.ps1 untuk setup awal server!" -ForegroundColor Green
}
