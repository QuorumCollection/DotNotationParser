SRC_FILES = $(shell find src -type f -name '*.php')

README.md: $(SRC_FILES)
	vendor/bin/mddoc

.PHONY: fix
fix: cbf
	vendor/bin/php-cs-fixer fix

.PHONY: phpstan
phpstan:
	vendor/bin/phpstan --memory-limit=2G

.PHONY: php-cs-fixer
php-cs-fixer:
	vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: test
test: cs php-cs-fixer phpstan
	vendor/bin/phpunit

.PHONY: cs
cs:
	vendor/bin/phpcs

.PHONY: cbf
cbf:
	vendor/bin/phpcbf
