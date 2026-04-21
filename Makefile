fix-cs: fix-code-style
fix-code-style:
	@vendor/bin/php-cs-fixer fix --allow-risky=yes --verbose --using-cache=no

lint-cs: lint-code-style
lint-code-style:
	@vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --stop-on-violation --diff --using-cache=no

analysis-code:
	@php -d memory_limit=-1 vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=-1

test:
	@php vendor/bin/phpunit --testdox
