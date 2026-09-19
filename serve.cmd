@echo off
cd /d "%~dp0"
"D:\laragon\bin\php\php-8.2.33-Win32-vs16-x64\php.exe" artisan serve --host=127.0.0.1 --port=8000 %*
