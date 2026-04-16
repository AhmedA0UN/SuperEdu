# SuperEdu

SuperEdu est organise en trois couches:

- `backend/` : API Laravel
- `node-service/` : passerelle Node.js et endpoint de supervision
- `frontend/` : application React/Vite qui expose les interfaces legacy de Super_Edu

## Vue d'ensemble

Le frontend React sert d'enveloppe autour des pages historiques stockees dans `frontend/public/super_edu/` et expose les routes suivantes:

- `/` : accueil React
- `/index` : `super_edu/index.html`
- `/certification` : `super_edu/Wpages/certification.html`
- `/conseils` : `super_edu/Wpages/conseils.html`
- `/mentor-ia` : `super_edu/Wpages/mentor IA.html`
- `/prototype` : `super_edu/Wpages/prototype.html`
- `/weeeelcom` : `super_edu/Wpages/weeeelcom.html`

## Prerequis

- PHP avec Composer pour `backend/`
- Node.js 18+ pour `frontend/` et `node-service/`
- Une base de donnees compatible Laravel si vous voulez utiliser les fonctions backend au-dela du healthcheck

## Demarrage local

Ouvrir trois terminaux, un par couche.

### 1) Backend Laravel

```bash
cd backend
copy .env.example .env
composer install
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

### 2) Node service

```bash
cd node-service
copy .env.example .env
npm install
npm start
```

### 3) Frontend React

```bash
cd frontend
npm install
npm run dev
```

## Variables d'environnement

### backend/.env

La configuration suit le format standard Laravel. Les champs a verifier en priorite sont ceux lies a la base de donnees, au cache, a la queue et au mail.

### node-service/.env

- `PORT` : port HTTP du service Node, par defaut `4000`
- `LARAVEL_API_URL` : URL de base de l'API Laravel, par defaut `http://localhost:8000/api`
- `FRONTEND_URL` : origine autorisee pour CORS, par defaut `http://localhost:5173`

## Endpoints

- Laravel health: `GET http://localhost:8000/api/health`
- Node health: `GET http://localhost:4000/health`
- Node status global: `GET http://localhost:4000/api/status`

## Scripts utiles

### frontend/

- `npm run dev` : lance Vite en mode developpement
- `npm run build` : genere le build de production dans `frontend/dist/`
- `npm run lint` : verifie le code front-end

### node-service/

- `npm start` : lance le service Node
- `npm run dev` : lance le service Node avec redemarrage automatique

## Verification rapide

```bash
cd frontend
npm run build
npm run lint
```

## Licence

SuperEdu est distribue sous triple licence. Vous pouvez utiliser le projet sous l'une des licences suivantes:

- GNU General Public License v3.0 ou version ulterieure
- MIT License
- Apache License 2.0

Les textes correspondants se trouvent dans:

- `LICENSE-GPL-3.0-or-later`
- `LICENSE-MIT`
- `LICENSE-APACHE-2.0`

Si vous distribuez ou modifiez ce projet, vous devez respecter les conditions de la licence que vous choisissez d'appliquer.
