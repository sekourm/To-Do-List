SHELL := /bin/bash

define add_host =
	if ! grep -xq "$1	$2" /etc/hosts; then \
	  echo -ne "\n$1	$2" | sudo tee --append /etc/hosts; \
	fi
endef

add_hosts:
	$(call add_host,10.5.0.5,back.epitech)
	$(call add_host,10.5.0.7,front.epitech)
	$(call add_host,10.5.0.6,pma.epitech)
cp_env:
	cp .env.dist .env
build:
	docker-compose build
run:
	docker-compose up

create_database:
	docker exec -it php-epi-back php bin/console doctrine:schema:update --force

install: cp_env add_hosts build run create_database