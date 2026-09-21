#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$ROOT"

PHP=("$ROOT/scripts/php.sh")

"${PHP[@]}" artisan migrate --force
"${PHP[@]}" artisan db:seed --force

cd "$ROOT/public"
exec "${PHP[@]}" -S 127.0.0.1:8000 \
  "$ROOT/vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php"
