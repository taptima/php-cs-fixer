THIS_FILE := $(lastword $(MAKEFILE_LIST))

-include .env

cs:
	bin/php-cs-fixer fix --verbose

cs-dry-run:
	bin/php-cs-fixer fix --verbose --dry-run

c-inst:
	composer install

gen-doc:
	tools/doc > README.md