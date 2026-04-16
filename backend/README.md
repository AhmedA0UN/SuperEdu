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
- Le healthcheck expose par cette application est disponible sur `GET /api/health`.

## Commandes utiles

- `php artisan migrate` : applique les migrations
- `php artisan test` : lance la suite de tests Laravel
- `php artisan route:list` : affiche les routes disponibles
