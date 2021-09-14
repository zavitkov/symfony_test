#!/usr/bin/env bash

# Down containers
sudo docker-compose down -v

# Start containers
sudo docker-compose up -d

# Wait
sleep 30

# Composer
sudo docker exec php_symfony_test sh -c "composer install"

# DB
sudo docker exec php_symfony_test sh -c "php bin/console doctrine:migrations:migrate --no-interaction"
sudo docker exec php_symfony_test sh -c "php bin/console doctrine:fixtures:load --no-interaction"
