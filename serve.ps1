Set-Location -Path $PSScriptRoot

if (Get-Command node -ErrorAction SilentlyContinue) {
    node serve.js
    exit
}

Write-Host "===================================================" -ForegroundColor Cyan
Write-Host "  LinksBase - Web Tools Hub" -ForegroundColor Green
Write-Host "===================================================" -ForegroundColor Cyan
Write-Host "Starting PHP server at http://localhost:8000 ..." -ForegroundColor Yellow
Write-Host "Press Ctrl+C to stop." -ForegroundColor DarkGray
Write-Host "===================================================" -ForegroundColor Cyan

$php = if (Test-Path "C:\xampp\php\php.exe") { "C:\xampp\php\php.exe" } else { "php" }

# Launch browser via explorer (safe across all Windows environments)
Start-Process "explorer.exe" -ArgumentList "http://localhost:8000"

& $php -S localhost:8000
