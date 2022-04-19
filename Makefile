vendor:
	composer install
	composer update --prefer-stable --no-interaction

.PHONY: db dataset test unit-test integration-test install install-dataset cache

db:
	php bin/console doctrine:database:drop --if-exists --no-interaction --force
	php bin/console doctrine:database:create --no-interaction
	php bin/console doctrine:migration:migrate --no-interaction

dataset:
	php bin/console doctrine:fixtures:load --append

test:
	php bin/phpunit

unit-test:
	php bin/phpunit --testsuite unit

integration-test:
	php bin/phpunit --testsuite integration

cache:
	php bin/console cache:clear --quiet --no-warmup
	php bin/console cache:warmup --quiet

install: vendor db cache

install-dataset: install dataset

install-simple: dataset cache

i: install

id: install-dataset

is: install-simple
