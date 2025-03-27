#!/usr/bin/zsh

echo '------ Starting deploy tasks  ------'

cp .env.example .env
composer install --prefer-dist --no-interaction --no-progress --ansi

yarn install
yarn build

touch database/database.sqlite

# DO NOT this in real world.
# This refresh the database on every deploy
php artisan migrate:fresh --seed --force

php artisan storage:link
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan icons:cache

echo '------ Deploy completed ------'
