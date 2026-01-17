@echo off
title (DON'T CLOSE) - Task Management System
color 0A

:: Get host input or fallback to local IP
set /p host=Enter Host: 
if "%host%"=="" for /f "tokens=2 delims=:" %%i in ('ipconfig ^| findstr /i "IPv4"') do (
    for /f "tokens=1 delims= " %%a in ("%%i") do set host=%%a
)

:: Get port input
set /p port=Enter Port: 
if "%port%"=="" set port=8553

echo.
echo System will be running in http://%host%:%port%
pause


:: start msedge http://%host%:%port%
php -S %host%:%port%