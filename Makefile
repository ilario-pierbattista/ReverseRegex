up start:
	docker compose up -d

down:
	docker compose down

restart re:
	make stop
	make start

shell enter:
	docker compose exec reverse-regex bash

log logs:
	docker-compose logs reverse-regex

tail follow:
	docker-compose logs --follow reverse-regex

composer-install:
	docker compose exec reverse-regex composer install

composer-dump:
	docker compose exec reverse-regex composer dump-autoload -o

lint:
	docker compose exec reverse-regex composer lint

lint-fix:
	docker compose exec reverse-regex composer lint:fix

stan:
	docker compose exec reverse-regex composer stan

test:
	docker compose exec reverse-regex composer test

all:
	docker compose exec reverse-regex composer lint
	docker compose exec reverse-regex composer stan
	docker compose exec reverse-regex composer test
