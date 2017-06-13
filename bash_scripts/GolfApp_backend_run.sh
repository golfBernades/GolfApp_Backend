#!/usr/bin/env bash
# Clona el repositorio de github o lo actualiza si ya existe

cd /var/www/html

if [ ! -d "GolfApp_Backend" ]; then
    echo Se va a clonar el repositorio de github
    git clone https://github.com/golfBernades/GolfApp_Backend.git
fi

cd GolfApp_Backend

echo Se va a actualizar el repositorio de github
git pull


# Detiene el proceso de laravel si ya se estaba corriendo

running_id=$(lsof -t -i:8080)

if [ -z "$running_id" ];
then
    echo Laravel no estaba corriendo
else
    echo Laravel está corriendo
    kill $running_id
    echo Laravel se detuvo
fi

# Ejecuta el proyecto de laravel

echo Se va a ejecutar Laravel

echo "php artisan serve --host 0.0.0.0 --port 8080" > ejecuta_laravel.sh

chmod 777 ejecuta_laravel.sh

nohup ./ejecuta_laravel.sh &>/dev/null &
