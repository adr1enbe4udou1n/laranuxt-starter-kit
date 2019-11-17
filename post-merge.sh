#!/bin/sh

# SERVER
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

composer install
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

yarn
yarn build

# CLIENT
yarn
yarn openapi http://{mysite}.example.com/docs/api-docs.json
yarn build

pm2 restart laranuxt
