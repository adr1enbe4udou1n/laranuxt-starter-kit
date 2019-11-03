#!/bin/sh

# BACK
composer install
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:clear

yarn && yarn build

# FRONT
yarn && yarn openapi http://{mysite}.example.com/docs/api-docs.json && yarn build
pm2 restart laranuxt
