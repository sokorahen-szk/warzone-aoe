eval "$(docker-machine env wzn)"

echo "php artisan config:clear"
php artisan config:clear

echo "php artisan cache:clear"
php artisan cache:clear

echo "php artisan route:clear"
php artisan route:clear