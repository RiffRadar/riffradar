#Docker
d-build :
	docker compose build

d-up :
	docker compose up -d

d-down : 
	docker compose down

d-start : 
	docker compose start

d-stop :
	docker compose stop

d-restart :
	docker compose restart

#Composer
composer-install :
	docker compose exec composer_sf composer install

#Symfony
sf-make-entity :
	docker compose exec composer_sf php bin/console make:entity $(entity)

sf-cache-clear : 
	docker compose exec composer_sf php bin/console cache:clear

sf-make-migration :
	docker compose exec composer_sf php bin/console make:migration

sf-migrate :
	docker compose exec composer_sf php bin/console doctrine:migrations:migrate 

sf-create-database :
	docker compose exec composer_sf php bin/console doctrine:database:create --if-not-exists

#Next
next-install :
	docker compose exec nextjs npm install

next-dev :
	docker compose exec nextjs npm run dev

next-build :
	docker compose exec nextjs npm run build
