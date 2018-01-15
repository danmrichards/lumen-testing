SHELL=/bin/bash
TIMESTAMP=local-$(shell date +%s) # Helm has a meltdown with purge numeric tags & converts them to scientific notation!

ifeq ($(findstring aggregators,$(CURDIR)),aggregators)
	SERVICE_NAME=agg-$(shell basename $(CURDIR))
else
	SERVICE_NAME=$(shell basename $(CURDIR))
endif

test:
	docker build -f ./Dockerfile -t $(SERVICE_NAME):$(TIMESTAMP) .
	docker run $(SERVICE_NAME):$(TIMESTAMP) ash -c './vendor/bin/phpunit'