#!/usr/bin/env bash
#
# deploy.sh — Server-side deployment script for Ciabay CMS.
#
# Run this ON THE PRODUCTION SERVER, inside the project directory, as the user
# that owns the webroot (commonly `www-data` or `root`). It pulls the latest
# code from the `main` branch, installs PHP dependencies, runs migrations, and
# primes the Laravel caches.
#
# Example (on the server):
#   cd /var/www/ciabay.com && ./deploy.sh
#
# The remote deploy trigger (runs from your local machine) lives in
# `.deploy/remote-deploy.sh`.

set -euo pipefail

cd "$(dirname "$0")"

# Pull latest code first, then re-exec the fresh script so bash doesn't run a
# stale buffered version of deploy.sh.
if [ -z "${DEPLOY_RELOADED:-}" ]; then
  echo "==> 1/7 git: fetch + reset to origin/main"
  git fetch --all --prune
  git reset --hard origin/main
  export DEPLOY_RELOADED=1
  exec bash "$(pwd)/deploy.sh" "$@"
fi

# --- running as fresh reload from here ---

PHP_BIN="${PHP_BIN:-}"
for _p in /opt/php8-3/bin/php-cli /opt/ferozo/php8-3/bin/php-cli /opt/php8-2/bin/php-cli /opt/php8-1/bin/php-cli; do
  if [ -x "$_p" ]; then PHP_BIN="$_p"; break; fi
done
if [ -z "$PHP_BIN" ]; then PHP_BIN="php"; fi
echo "==> using PHP: $($PHP_BIN -v 2>&1 | head -1)"

echo "==> 2/7 composer install (production)"
"$PHP_BIN" /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Frontend assets: only rebuild if node is present. Otherwise trust repo-committed build.
if command -v npm >/dev/null 2>&1 && [ -f package.json ]; then
  echo "==> 3/7 npm install + build"
  npm ci --no-audit --no-fund || npm install --no-audit --no-fund
  npm run build
else
  echo "==> 3/7 skipping npm (not installed)"
fi

echo "==> 4/7 storage:link"
"$PHP_BIN" artisan storage:link 2>/dev/null || true

echo "==> 5/7 migrate (production, forced)"
"$PHP_BIN" artisan migrate --force

echo "==> 6/7 clear + rebuild caches"
"$PHP_BIN" artisan optimize:clear
"$PHP_BIN" artisan config:cache
"$PHP_BIN" artisan route:cache
"$PHP_BIN" artisan view:cache

echo "==> 7/7 writable permissions on storage + bootstrap/cache"
# Best-effort: ensure the web user can write cache/logs even if repo cloning
# set tighter permissions.
if [ -n "${WEB_USER:-}" ]; then
  chown -R "$WEB_USER":"$WEB_USER" storage bootstrap/cache || true
fi
chmod -R ug+rw storage bootstrap/cache || true

echo "✓ deploy done"
