#!/bin/bash
# Auto fix script.


/usr/bin/php5 ./vendor/squizlabs/php_codesniffer/scripts/phpcbf \
    --standard=PSR2 \
    --ignore=*/vendor/* \
    .