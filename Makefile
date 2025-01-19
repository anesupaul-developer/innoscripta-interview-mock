COMPOSE_PROJECT_NAME := application

start_parser:
	docker-compose --env-file=./newsparser/src/.env \
 		-f ./newsparser/docker-compose.yml \
		up -d --build --remove-orphans
	docker exec -it newsparser-php-1 composer install
	docker exec -it newsparser-php-1 php artisan key:generate
	docker exec -it newsparser-php-1 php artisan migrate

start_app:
	docker-compose --env-file=./frontend/src/.env \
 		-f ./frontend/docker-compose.yml \
		up -d --build --remove-orphans
	docker exec -it frontend-php-1 composer install
	docker exec -it frontend-php-1 php artisan key:generate
	docker exec -it frontend-php-1 php artisan migrate
	cd frontend/src && docker-compose run npm install && docker-compose run npm run build

produce_articles:
	docker exec -it newsparser-php-1 php artisan app:nyt-articles
	docker exec -it newsparser-php-1 php artisan app:guardian-articles
	docker exec -it newsparser-php-1 php artisan app:news-org-articles

consume_articles:
	docker exec -it frontend-php-1 php artisan queue:work

db_clean:
	docker exec -it frontend-php-1 php artisan migrate:fresh
