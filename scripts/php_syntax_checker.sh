#!/bin/bash

echo "Checking PHP syntax..."

FILES=$(find . -type f -name "*.php")

if [ -z "$FILES" ]; then
    echo "No PHP files found."
    exit 0
fi

for file in $FILES
do

    echo "Checking: $file"

    php -l "$file"

    if [ $? -ne 0 ]; then
        echo "❌ Syntax error found in $file"
        exit 1
    fi

done

echo "✅ PHP syntax validation passed."