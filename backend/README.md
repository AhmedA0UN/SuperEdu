# Backend Laravel

Ce dossier contient l'API Laravel de SuperEdu.

## Demarrage

```bash
copy .env.example .env
composer install
php artisan key:generate
php artisan serve --host=127.0.0.1 --port=8000
```

## Configuration utile

- `APP_NAME`, `APP_URL` et les donnees de connexion base de donnees doivent etre adaptes a votre environnement local.
- Les endpoints techniques exposes par cette application sont disponibles sur `GET /api/health` et `GET /api/status`.
- Le chat AI est expose sur `POST /api/ai/chat` et requiert `AI_API_KEY` plus `AI_BASE_URL`.

## Commandes utiles

- `php artisan migrate` : applique les migrations
- `php artisan test` : lance la suite de tests Laravel
- `php artisan route:list` : affiche les routes disponibles

## Configuration AI

- `AI_PROVIDER` : fournisseur logique, `openai` par défaut.
- `AI_BASE_URL` : base URL compatible OpenAI, par exemple `https://api.openai.com/v1`.
- `AI_API_KEY` : clé d'API du provider.
- `AI_MODEL` : modèle à utiliser, par défaut `gpt-4o-mini`.
- `AI_ORGANIZATION` : organisation optionnelle pour OpenAI.
- `AI_TIMEOUT` : délai max de la requête en secondes.
