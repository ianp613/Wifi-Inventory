@echo off

:: RUN PHP
start "Unifi Bot Network 15" /min php -S 192.168.15.221:1525

:: RUN PYTHON
start "" cmd /c "cd /d %~dp0bot && serve.bat"

echo [*] Some of Unifi Wifi Bot processes will be running in the background.
echo [*] Please use terminate.bat to stop the Unifi Wifi Bot.

pause
exit