.PHONY: run-php-7.4
run-php-7.4:
	docker compose run php74 sh

.PHONY: run-php-8.0
run-php-8.0:
	docker compose run php80 sh

.PHONY: run-php-8.1
run-php-8.1:
	docker compose run php81 sh

.PHONY: run-php-8.2
run-php-8.2:
	docker compose run php82 sh

.PHONY: run-php-8.3
run-php-8.3:
	docker compose run php83 sh

.PHONY: run-php-8.4
run-php-8.4:
	docker compose run php84 sh
