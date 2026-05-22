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

    # Skip wildcard patterns
    [[ "$line" == *"*"* ]] && continue

    # Skip pure file entries
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

# Get only added/copied/modified PHP files
CHANGED_FILES=$(git diff --name-only --diff-filter=ACM origin/main...HEAD | grep '\.php$')

if [ -z "$CHANGED_FILES" ]; then
  echo "No changed PHP files found."
  exit 0
fi

# Apply existing exclude logic
FILTERED_FILES=""

while IFS= read -r file
do

  skip=false

  for arg in "${EXCLUDE_ARGS[@]}"
  do
    if [[ "$file" == ${arg#./}* ]]; then
      skip=true
      break
    fi
  done

  if [ "$skip" = false ]; then
    FILTERED_FILES+="$file"$'\n'
  fi

done <<< "$CHANGED_FILES"

if [ -z "$FILTERED_FILES" ]; then
  echo "No valid PHP files to check."
  exit 0
fi

FAILED=0

while IFS= read -r file
do

  [ -z "$file" ] && continue

  echo "Checking: $file"

  php -l "$file" > /dev/null 2>&1

  if [ $? -ne 0 ]; then
    echo "❌ Syntax error found in $file"
    php -l "$file"
    FAILED=1
  fi

done <<< "$FILTERED_FILES"

if [ "$FAILED" -eq 1 ]; then
  echo "❌ PHP syntax validation failed."
  exit 1
fi

echo "✅ PHP syntax validation passed."