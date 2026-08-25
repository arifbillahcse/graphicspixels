#!/usr/bin/env bash
#
# One-shot setup: scaffolds Laravel around this overlay, installs everything,
# migrates, seeds and runs the test suite.
#
# The overlay in this directory is not a complete Laravel application — the
# environment it was written in had Composer and npm blocked, so the framework
# could never be installed there. This script does what could not be done then.
#
# Usage:   bash tools/setup.sh
# Safe to re-run: existing overlay files are never overwritten.

set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SCAFFOLD_DIR="$(mktemp -d)"

cleanup() { rm -rf "$SCAFFOLD_DIR"; }
trap cleanup EXIT

say()  { printf '\n\033[1;34m==>\033[0m %s\n' "$1"; }
fail() { printf '\n\033[1;31mFAILED:\033[0m %s\n' "$1" >&2; exit 1; }

# ---------------------------------------------------------------- preflight

say "Checking prerequisites"

command -v php      >/dev/null || fail "php is not installed"
command -v composer >/dev/null || fail "composer is not installed"
command -v npm      >/dev/null || fail "npm is not installed"

PHP_MAJOR_MINOR="$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')"
say "php $PHP_MAJOR_MINOR, $(composer --version | head -1), npm $(npm --version)"

php -r 'exit(version_compare(PHP_VERSION, "8.2.0", ">=") ? 0 : 1);' \
  || fail "Laravel 11 needs PHP 8.2 or newer; found $PHP_MAJOR_MINOR"

if [ -f "$APP_DIR/vendor/autoload.php" ]; then
  say "vendor/ already present — skipping scaffold, refreshing dependencies only"
  cd "$APP_DIR"
  composer install
else
  # ------------------------------------------------------------- scaffold
  #
  # Breeze and Spatie publish their own routes/web.php and layouts/app.blade.php.
  # The overlay deliberately replaces both, so the scaffold is built first in a
  # temporary directory and then copied in WITHOUT overwriting anything.

  say "Scaffolding Laravel 11 in $SCAFFOLD_DIR"
  composer create-project --no-interaction laravel/laravel:^11.0 "$SCAFFOLD_DIR/app"

  cd "$SCAFFOLD_DIR/app"

  say "Installing Breeze"
  composer require --no-interaction --dev laravel/breeze
  php artisan breeze:install blade --no-interaction

  say "Installing Spatie permissions"
  composer require --no-interaction spatie/laravel-permission
  php artisan vendor:publish \
    --provider="Spatie\Permission\PermissionServiceProvider" --no-interaction

  say "Merging the scaffold under the overlay"
  # -n: never clobber an overlay file.
  cp -rn "$SCAFFOLD_DIR/app/." "$APP_DIR/"

  cd "$APP_DIR"
fi

# ------------------------------------------------------------------ assets

say "Building frontend assets"
npm install
npm run build

# --------------------------------------------------------------- environment

cd "$APP_DIR"

if [ ! -f .env ]; then
  say "Creating .env"
  cp .env.example .env
  php artisan key:generate
fi

# SQLite keeps local setup to zero moving parts. Swap DB_CONNECTION for MySQL
# in production; nothing in the application code changes.
if ! grep -q '^DB_CONNECTION=sqlite' .env; then
  say "Pointing .env at SQLite"
  touch database/database.sqlite
  sed -i.bak -E 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
  sed -i.bak -E 's/^DB_(HOST|PORT|DATABASE|USERNAME|PASSWORD)=/# DB_\1=/' .env
  rm -f .env.bak
fi

# Notifications are queued, so without a driver they would never be delivered.
if ! grep -q '^QUEUE_CONNECTION=database' .env; then
  say "Switching the queue to the database driver"
  sed -i.bak -E 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=database/' .env
  rm -f .env.bak
  php artisan queue:table --no-interaction 2>/dev/null || true
fi

# ---------------------------------------------------------------- database

say "Running migrations"
php artisan migrate --force

say "Seeding roles, permissions and 15 staff accounts"
php artisan db:seed --force

# -------------------------------------------------------------------- tests

say "Running the test suite"
if php artisan test; then
  TEST_RESULT="passed"
else
  TEST_RESULT="FAILED"
fi

# ------------------------------------------------------------ static checks

say "Running the standalone harnesses"
for p in 1 2 3 4 5 6; do
  php "tools/verify-phase${p}-standalone.php" | tail -1
done
php tools/check-blade.php | tail -1
php tools/check-references.php | tail -1

# --------------------------------------------------------------------- done

cat <<BANNER

------------------------------------------------------------------
Setup complete. Test suite: $TEST_RESULT

  php artisan serve

Sign in with any seeded account, password "password":

  admin@graphicspixels.test        full access
  marketing1@graphicspixels.test   lead pipeline
  production1@graphicspixels.test  production board
  lead1@graphicspixels.test        team leader queue
  editor1@graphicspixels.test      my batches only
  qc1@graphicspixels.test          QC queue

For notifications and SLA alerts, run a worker alongside the server:

  php artisan queue:work
  php artisan orders:check-sla --dry-run
------------------------------------------------------------------
BANNER

[ "$TEST_RESULT" = "passed" ] || exit 1
