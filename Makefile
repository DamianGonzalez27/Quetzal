#!/bin/bash

DOCKER_BE = panel-be
OS := $(shell uname)
UID = 1000

help: ## Mensaje de ayuda
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Levantando los contenedores
	docker network create quetzal-network || true
	U_ID=${UID} docker-compose up -d --remove-orphans

stop: ## Detener los contenedores
	U_ID=${UID} docker-compose stop

restart: ## Reiniciar los contenedores
	$(MAKE) stop && $(MAKE) run

build: ## Reconstruir los contenedores
	U_ID=${UID} docker-compose build

# Comandos de backend
composer-install: ## Instalar librerias de composer
	U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install --no-scripts --no-interaction --optimize-autoloader

ssh-be: ## Conexion SSH al contenedor nginx
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash