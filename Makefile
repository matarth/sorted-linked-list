bash:
	docker compose run --rm php bash

test:
	docker compose run --rm php ./vendor/bin/phpunit tests

cs:
	docker compose run --rm php ./vendor/bin/php-cs-fixer fix src --diff

phpstan:
	docker compose run --rm php ./vendor/bin/phpstan analyse src tests --level=max
