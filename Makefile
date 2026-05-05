bash:
	docker compose run --rm php bash

test:
	docker compose run --rm php composer test

cs:
	docker compose run --rm php composer cs

cs-check:
	docker compose run --rm php composer cs:check

phpstan:
	docker compose run --rm php composer phpstan

check:
	docker compose run --rm php composer check
