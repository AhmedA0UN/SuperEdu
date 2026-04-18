# SuperEdu Setup

Guide rapide pour installer SuperEdu localement et preparer la publication GitHub Pages.

## Prerequisites

- Node.js 18+
- PHP 8+
- Composer
- GitHub repository access (pour Pages)

## Quick start (automatique)

Depuis la racine du depot:

- Windows batch: `setup\setup.bat`
- Windows executable: `setup\setup.exe` (ou `setup.exe` si present a la racine)
- macOS/Linux: `sh setup/setup.sh`

Ces scripts:

- copient les `.env` manquants
- installent les dependances backend/node/frontend
- generent la cle Laravel si necessaire
- lancent un build frontend de verification

## Demarrage manuel des services

### Backend Laravel

```bash
cd backend
php artisan serve --host=127.0.0.1 --port=8000
```

### Node gateway

```bash
cd node-service
npm start
```

### Frontend

```bash
cd frontend
npm run dev
```

## Validation

```bash
cd frontend
npm run lint
npm run build
```

## GitHub Pages

1. Push sur `main`.
2. Dans GitHub: `Settings` -> `Pages`.
3. Selectionner `GitHub Actions` comme source.
4. Le workflow `.github/workflows/static.yml` publie `frontend/dist`.

Le workflow injecte `VITE_BASE_PATH`, cree `404.html` et ajoute `.nojekyll` pour un fonctionnement correct en sous-chemin.

## Variables d'environnement utiles

### frontend/.env

- `VITE_BASE_PATH` (defaut: `/`)

### node-service/.env

- `PORT` (defaut: `4000`)
- `LARAVEL_API_URL` (defaut: `http://localhost:8000/api`)
- `FRONTEND_ORIGINS` (origines CORS separees par des virgules)

