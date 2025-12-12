:: @echo off
:: title "DO NOT CLOSE THIS WINDOW"
:: call telebot_wifi\Scripts\activate.bat
:: python main.py
:: pause

@echo off
call telebot_wifi\Scripts\activate.bat
powershell -command "Start-Process python -ArgumentList 'main.py' -WindowStyle Hidden"
exit
