bash:
	docker compose run --rm php bash

test:
	docker compose run --rm php ./vendor/bin/phpunit tests
