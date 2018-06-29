#!/bin/bash
# Check project for standards.
# Required php5 installed!
# Without argument $1 - check all with summary report.

if [ -z $1 ]; then
    FILE="."
    REPORT="summary"
else
    FILE=$1
    REPORT="full"
fi

/usr/bin/php5 ./vendor/squizlabs/php_codesniffer/scripts/phpcs \
    --colors \
    --standard=PSR2 \
    --report=$REPORT \
    --report-width=auto \
    --ignore=*/vendor/* \
    $FILE