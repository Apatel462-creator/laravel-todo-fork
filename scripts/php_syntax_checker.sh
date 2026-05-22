#!/bin/bash

echo "Checking PHP syntax..."

# Build exclude args for find from .gitignore
EXCLUDE_ARGS=()

if [ -f ".gitignore" ]; then
  while IFS= read -r line; do
    # Skip empty lines and comments
    [[ -z "$line" || "$line" == \#* ]] && continue

    # Strip trailing slashes and leading slashes
    line="${line%/}"
    line="${line#/}"

    # Skip wildcard patterns (find can't handle globs like storage/*.key)
    [[ "$line" == *"*"* ]] && continue

    # Skip pure file entries (no directory, has extension e.g. .env, Homestead.yaml)
    # We only want to prune directories/paths for PHP scanning purposes
    basename="${line##*/}"
    if [[ "$basename" == *.* && "$basename" != "*" ]]; then
      continue
    fi

    if [ ${#EXCLUDE_ARGS[@]} -eq 0 ]; then
      EXCLUDE_ARGS+=(-path "./$line" -prune)
    else
      EXCLUDE_ARGS+=(-o -path "./$line" -prune)
    fi

  done < ".gitignore"
fi

# Find all .php files, excluding gitignore dirs
if [ ${#EXCLUDE_ARGS[@]} -gt 0 ]; then
  FILES=$(find . \( "${EXCLUDE_ARGS[@]}" \) -o -type f -name "*.php" -print)
else
  FILES=$(find . -type f -name "*.php" -print)
fi

if [ -z "$FILES" ]; then
  echo "No PHP files found."
  exit 0
fi

FAILED=0

while IFS= read -r file; do
  echo "Checking: $file"

  php -l "$file" > /dev/null 2>&1

  if [ $? -ne 0 ]; then
    echo "❌ Syntax error found in $file"
    php -l "$file"
    FAILED=1
  fi

done <<< "$FILES"

if [ "$FAILED" -eq 1 ]; then
  echo "❌ PHP syntax validation failed."
  exit 1
fi

echo "✅ PHP syntax validation passed."