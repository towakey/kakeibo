@echo off
echo Starting Kakeibo project setup...

REM Copy .env file if it doesn't exist
if not exist .env (
    copy .env.example .env
    echo Created .env file from .env.example
)

REM Create database directory if it doesn't exist
if not exist database (
    mkdir database
)

REM Remove existing SQLite database file if it exists
if exist database\database.sqlite (
    del database\database.sqlite
    echo Removed existing SQLite database file
)

REM Create SQLite database file
type nul > database\database.sqlite
echo Created SQLite database file

REM Install Composer dependencies
echo Installing Composer dependencies...
call composer install

REM Install NPM dependencies
echo Installing NPM dependencies...
call npm install

REM Generate application key
echo Generating application key...
php artisan key:generate

REM Run database migrations
echo Running database migrations...
php artisan migrate:fresh

REM Run database seeder
echo Running database seeders...
php artisan db:seed

REM Build assets
echo Building assets...
call npm run build

echo Setup completed successfully!
pause
