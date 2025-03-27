#!/usr/bin/zsh

echo '------ Starting deploy tasks  ------'

touch database/database.sqlite

# DO NOT the database production.
# We do it here because it is a demo and we refresh the database on every deploy
php artisan migrate:fresh --seed --force

php artisan storage:link
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan icons:cache

echo '------ Deploy completed ------'
