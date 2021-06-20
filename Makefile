.DEFAULT_GOAL := all

DOCKER_COMPOSE := docker-compose
DOCKER_FOLDER := ./.docker

PHP_COMPOSE := $(DOCKER_COMPOSE) -f $(DOCKER_FOLDER)/docker-compose.yml --env-file=$(DOCKER_FOLDER)/.env
NODE_COMPOSE := $(DOCKER_COMPOSE) -f $(DOCKER_FOLDER)/node-docker-compose.yml

up:
	@$(PHP_COMPOSE) up -d
	@make dev-server

dev-server:
	@$(NODE_COMPOSE) up -d

dev-server-stop:
	@$(NODE_COMPOSE) down

test:
	@$(PHP_COMPOSE) run --rm php-cli /var/www/application/bin/phpunit --testdox
