@echo off
echo [*] Terminating all UNIFI WIFI BOT processes

:: Kill all php.exe processes
taskkill /IM php.exe /F >nul 2>&1

:: Kill all python.exe processes
taskkill /IM python.exe /F >nul 2>&1

echo [*] UNIFI WIFI BOT has been terminated

pause
exit