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
- L'etat de configuration AI est disponible sur `GET /api/ai/health`.
- Le chat AI est expose sur `POST /api/ai/chat` et requiert `AI_API_KEY` plus `AI_BASE_URL`.

## Commandes utiles

- `php artisan migrate` : applique les migrations
- `php artisan test` : lance la suite de tests Laravel
- `php artisan route:list` : affiche les routes disponibles
- `php artisan ai:ask Bonjour` : interroge la vraie IA depuis le backend

## Configuration AI

- `AI_PROVIDER` : fournisseur logique, `openai` par défaut.
- `AI_BASE_URL` : base URL compatible OpenAI, par exemple `https://api.openai.com/v1`.
- `AI_API_KEY` : clé d'API du provider.
- `AI_MODEL` : modèle à utiliser, par défaut `gpt-4o-mini`.
- `AI_ORGANIZATION` : organisation optionnelle pour OpenAI.
- `AI_TIMEOUT` : délai max de la requête en secondes.

## Script backend AI (CLI)

Commande de base:

```bash
php artisan ai:ask "Explique le pattern Observer"
```

Avec assistant cible:

```bash
php artisan ai:ask "Aide-moi a reviser les limites" --assistant=mentor
```

Avec contexte JSON:

```bash
php artisan ai:ask "Prepare un mini quiz" --assistant=superbot --context='{"subject":"mathematiques","level":"intermediaire"}'
```

Payload API `POST /api/ai/chat` (exemple):

```json
{
	"assistant": "mentor",
	"message": "Aide-moi a organiser ma semaine",
	"context": { "source": "frontend" },
	"history": [
		{ "role": "user", "content": "Bonjour" },
		{ "role": "assistant", "content": "Salut, comment puis-je t'aider ?" }
	]
}
```
