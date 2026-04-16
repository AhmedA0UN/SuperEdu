# BestEdu Production Stack

Architecture de production basee sur trois couches:

- `backend/` : API Laravel
- `node-service/` : service Node.js (gateway et observabilite)
- `frontend/` : client React.js avec les memes pages/interfaces de `Super_Edu`

## Pages conservees de Super_Edu

Les interfaces graphiques originales sont conservees dans `frontend/public/super_edu/` et exposees via React Router:

- `/index` -> `super_edu/index.html`
- `/certification` -> `super_edu/Wpages/certification.html`
- `/conseils` -> `super_edu/Wpages/conseils.html`
- `/mentor-ia` -> `super_edu/Wpages/mentor IA.html`
- `/prototype` -> `super_edu/Wpages/prototype.html`
- `/weeeelcom` -> `super_edu/Wpages/weeeelcom.html`

## Lancement local (mode production-ready)

Ouvrir 3 terminaux.

### 1) Backend Laravel

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

### 2) Node service

```bash
cd node-service
cp .env.example .env
npm install
npm start
```

### 3) Frontend React

```bash
cd frontend
npm install
npm run dev
```

## Endpoints de sante

- Laravel: `GET http://localhost:8000/api/health`
- Node.js: `GET http://localhost:4000/health`
- Node.js status global: `GET http://localhost:4000/api/status`

## Build frontend production

```bash
cd frontend
npm run build
```

Le build est genere dans `frontend/dist/`.
