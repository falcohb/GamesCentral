.PHONY: run php-stan

run:
	symfony server:start -d

abort:
	symfony server:stop

php-stan:
	./vendor/bin/phpstan analyse
