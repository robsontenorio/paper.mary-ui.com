#!/usr/bin/zsh

echo '------ Starting deploy tasks  ------'

cp .env.example .env
composer install --prefer-dist --no-interaction --no-progress --ansi

yarn install
yarn build

touch database/database.sqlite
php artisan migrate:fresh --seed --force

php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan icons:cache

echo '------ Deploy completed ------'
