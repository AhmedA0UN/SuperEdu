# SuperEdu Setup

This file gives the shortest path to get SuperEdu running locally and published on GitHub Pages.

## Prerequisites

- Node.js 18+ for the frontend and Node gateway
- PHP 8+ and Composer for the Laravel backend
- GitHub repository access if you want to publish with GitHub Actions

## Local setup

You can automate the steps with the root scripts:

- `setup/setup.bat` on Windows
- `setup/setup.sh` on macOS/Linux
- `setup.exe` on Windows

### 1) Backend

```bash
cd backend
copy .env.example .env
composer install
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

### 2) Node gateway

```bash
cd node-service
copy .env.example .env
npm install
npm start
```

### 3) Frontend

```bash
cd frontend
copy .env.example .env
npm install
npm run dev
```

## Validation

```bash
cd frontend
npm run lint
npm run build
```

## GitHub Pages setup

1. Push the repository to GitHub.
2. Open the repository settings.
3. Go to `Pages`.
4. Select `GitHub Actions` as the source.
5. Push to `main` to trigger `.github/workflows/static.yml`.

The workflow builds the frontend with the correct base path, generates a `404.html` fallback, and publishes only `frontend/dist`.

## Environment variables

### frontend/.env

- `VITE_BASE_PATH` controls the public base path used by Vite.

### node-service/.env

- `PORT` defaults to `4000`
- `LARAVEL_API_URL` defaults to `http://localhost:8000/api`
- `FRONTEND_ORIGINS` is a comma-separated allowlist for CORS
