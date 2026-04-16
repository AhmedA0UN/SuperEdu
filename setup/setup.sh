#!/usr/bin/env sh
set -eu

SETUP_DIR=$(CDPATH= cd -- "$(dirname -- "$0")" && pwd)
ROOT_DIR=$(CDPATH= cd -- "$SETUP_DIR/.." && pwd)

echo "[1/4] Backend Laravel"
cd "$ROOT_DIR/backend"
if [ ! -f .env ]; then
  cp .env.example .env
fi
composer install
if grep -q '^APP_KEY=$' .env; then
  php artisan key:generate
fi

echo "[2/4] Node service"
cd "$ROOT_DIR/node-service"
if [ ! -f .env ]; then
  cp .env.example .env
fi
npm install

echo "[3/4] Frontend"
cd "$ROOT_DIR/frontend"
if [ ! -f .env ]; then
  cp .env.example .env
fi
npm install
npm run build

echo "[4/4] Done"
echo "You can now start the apps with:"
echo "  backend:    cd backend && php artisan serve --host=127.0.0.1 --port=8000"
echo "  node:       cd node-service && npm start"
echo "  frontend:   cd frontend && npm run dev"