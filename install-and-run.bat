@echo off
echo Installing Laravel Application...

echo Installing Composer Dependencies...
composer install

echo Generating Application Key...
php artisan key:generate

echo Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo Running Migrations...
php artisan migrate --force

echo Seeding Database...
php artisan db:seed --force

echo Installation Complete!
echo Starting Server...
php artisan serve