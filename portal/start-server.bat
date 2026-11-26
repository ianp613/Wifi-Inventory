@echo off
REM Starts the portal with PHP's built-in web server (no Apache/nginx needed).
REM Usage: start-server.bat [port]     (default 8080). Run from this folder.
set PORT=%1
if "%PORT%"=="" set PORT=8080
php -S 0.0.0.0:%PORT% -t public dev/router.php
