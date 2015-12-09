#!/bin/bash

#PHP UNIT
docker run --rm -v $PWD:$PWD -w $PWD jolicode/phaudit phpunit src

# PHP Code Sniffer
docker run --rm -v $PWD:$PWD -w $PWD jolicode/phaudit phpcs --standard=PSR2 --ignore=vendor,Test .
