# Frontend SuperEdu

Cette application React/Vite sert de couche d'entree pour les pages historiques de Super_Edu conservees dans `public/super_edu/`.

## Ce que contient le frontend

- Une page d'accueil React qui liste les interfaces disponibles
- Des routes React qui chargent les pages legacy dans un `iframe`
- Les fichiers HTML d'origine dans `public/super_edu/`

## Routes exposees

- `/` : accueil
- `/index` : interface principale
- `/certification` : page de certification
- `/conseils` : page de conseils
- `/mentor-ia` : mentor IA
- `/prototype` : prototype
- `/weeeelcom` : page d'accueil alternative

## Scripts

- `npm run dev` : lance le serveur de developpement Vite
- `npm run build` : genere le build de production
- `npm run preview` : previsualise le build localement
- `npm run lint` : verifie le code avec ESLint

## Notes d'exploitation

- Le service React suppose que le frontend est accessible sur `http://localhost:5173` en developpement.
- Les pages legacy peuvent etre ouvertes directement depuis leur route React ou en acces direct via `public/super_edu/`.
- `npm run build` ecrit la sortie dans `dist/`.
