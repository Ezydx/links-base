@echo off
title LinksBase - Web Tools Hub
cd /d "%~dp0"

where node >nul 2>&1
if %ERRORLEVEL% equ 0 (
    node serve.js
    goto :eof
)

echo ===================================================
echo   LinksBase - Personal Bookmarks & Web Hub
echo ===================================================
echo Starting PHP server at http://localhost:8000 ...
echo (Press Ctrl+C to stop)
echo ===================================================

:: Trigger browser opening in background after 1s delay
start /min cmd /c "ping 127.0.0.1 -n 2 >nul & explorer http://localhost:8000"

if exist "C:\xampp\php\php.exe" (
    "C:\xampp\php\php.exe" -S localhost:8000
) else (
    php -S localhost:8000
)
