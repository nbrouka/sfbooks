# Computer Books API

Implementation of Computer Books API

## Run this commands

Start docker containers:

    docker-compose up --build -d

Command used to run bash inside the docker container:

    docker-compose exec php bash

## Run this commands inside the docker container

Install dependent PHP packages:

    composer install

Command used to run the coding style checker:

    ./vendor/bin/phpcs

Command used to run the coding style fixer:

    ./vendor/bin/phpcbf

    or/and

    ./vendor/bin/php-cs-fixer fix src

Command used to run the static analyses:

    ./vendor/bin/phpstan analyse

Command used to run the phpunit tests:

    ./vendor/bin/phpunit tests --coverage-text --coverage-filter src

## Total docker reset

In case you will run into any sort of trouble with docker containers, you may want to start with a clean slate.
The following set of commands will delete absolutely everything in docker (containers, images, volumes...)

    # Stop all running containers
    sudo docker stop $(sudo docker ps -q)

    # Delete all images/containers
    sudo docker system prune -a

    # Delete all volumes
    sudo docker volume rm $(sudo docker volume ls -q)
