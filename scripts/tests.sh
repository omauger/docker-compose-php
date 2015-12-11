#!/bin/bash

#PHP UNIT
docker run --rm -v $PWD:$PWD -w $PWD jolicode/phaudit phpunit --coverage-text --strict-coverage src || exit 1

# PHP Code Sniffer
docker run --rm -v $PWD:$PWD -w $PWD jolicode/phaudit phpcs --standard=PSR2 --ignore=vendor,Test . || exit 1
