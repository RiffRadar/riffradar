COMPOSER = composer_sf

build :
	docker compose build

up :
	docker compose up -d

#Symfony
make-entity :
	docker compose exec $(COMPOSER) php bin/console make:entity $(entity)