.PHONY: run-php-8.1
run-php-8.1:
	docker compose run --remove-orphans php81 sh

.PHONY: run-php-8.2
run-php-8.2:
	docker compose run --remove-orphans php82 sh

.PHONY: run-php-8.3
run-php-8.3:
	docker compose run --remove-orphans php83 sh

.PHONY: run-php-8.4
run-php-8.4:
	docker compose run --remove-orphans php84 sh

DK:=docker compose run --rm php81
.PHONY: setup cs-fix test phpstan phpstan-update-baseline
setup:
	$(DK) composer install
test:
	$(DK) composer test
cs-fix:
	$(DK) composer cs-fix
phpstan:
	$(DK) composer phpstan
phpstan-update-baseline:
	$(DK) composer phpstan-baseline