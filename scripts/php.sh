#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
EXT="${ROOT}/.php-ext/usr/lib/php/20230831"

PHP=(php
  -d "extension=${EXT}/sqlite3.so"
  -d "extension=${EXT}/pdo_sqlite.so"
)

exec "${PHP[@]}" "$@"
