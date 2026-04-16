# Super_Edu

Plateforme web educative orientee vers l'apprentissage, la collaboration academique et l'accompagnement des etudiants.

## Sommaire

- [Objectif](#objectif)
- [Etat du projet](#etat-du-projet)
- [Public cible](#public-cible)
- [Fonctionnalites](#fonctionnalites)
- [Apercu des pages](#apercu-des-pages)
- [Captures d'ecran](#captures-decran)
- [Structure du projet](#structure-du-projet)
- [Demarrage rapide](#demarrage-rapide)
- [Utilisation](#utilisation)
- [Technologies](#technologies)
- [Compatibilite](#compatibilite)
- [Organisation du contenu](#organisation-du-contenu)
- [Deploiement](#deploiement)
- [FAQ](#faq)
- [Depannage](#depannage)
- [Roadmap](#roadmap-proposition)
- [Contribution](#contribution)
- [Licence](#licence)

## Objectif

Super_Edu a pour but d'aider les etudiants a renforcer leurs competences academiques et professionnelles via une experience numerique moderne.

## Etat du projet

- Statut : prototype fonctionnel d'interface educative.
- Type : application web statique (pas de backend obligatoire pour l'instant).
- Priorite actuelle : structuration du contenu, experience utilisateur et evolution vers une base plus modulaire.

## Public cible

- Etudiants en formation initiale ou continue.
- Enseignants souhaitant partager des contenus et collaborer.
- Mentors/encadrants accompagnant les parcours de progression.

## Fonctionnalites

- Parcours de contenu pedagogique (videos, cours, supports).
- Espaces de collaboration entre etudiants et enseignants.
- Accompagnement autour du developpement personnel et professionnel.
- Integration d'un assistant IA pour guider l'apprentissage.

## Apercu des pages

- `index.html` : point d'entree principal de l'interface.
- `Wpages/certification.html` : informations liees aux certifications.
- `Wpages/conseils.html` : conseils et recommandations.
- `Wpages/mentor IA.html` : espace dedie au mentor IA.
- `Wpages/prototype.html` : version/prototype d'interface.
- `Wpages/weeeelcom.html` : page d'accueil alternative.

## Captures d'ecran

### Vue principale

![Super_Edu - Vue principale](src/p1.png)

<!--
### Galerie

![Super_Edu - Ecran 2](src/v2.png)
![Super_Edu - Ecran 3](src/v3.png)
![Super_Edu - Dashboard 1](src/d1.png)
![Super_Edu - Dashboard 2](src/d2.png)
![Super_Edu - Dashboard 3](src/d3.png)
![Super_Edu - Certification](imgs/superedu-cert.png)

-->

## Structure du projet

```text
Super_Edu/
|-- index.html
|-- README.md
|-- config/
|-- imgs/
|-- media/
|-- src/
|   |-- presentaions/
|   `-- video/
`-- Wpages/
```

## Lancer le projet en local

Ce projet est statique (HTML/CSS/JS) et ne necessite pas de build complexe.

## Demarrage rapide

1. Cloner le depot.
2. Ouvrir le dossier dans VS Code.
3. Lancer `index.html` avec une extension de serveur local (exemple : Live Server) ou ouvrir directement le fichier dans le navigateur.

Option via terminal (Python, si disponible) :

```bash
python -m http.server 8080
```

Puis ouvrir : `http://localhost:8080`

## Utilisation

1. Ouvrir la page d'accueil (`index.html`).
2. Naviguer vers les pages de contenu dans `Wpages/`.
3. Explorer les sections pedagogiques (videos, conseils, certifications, mentor IA).
4. Adapter les textes/styles dans les fichiers HTML/CSS selon vos besoins.

## Technologies

- HTML5
- CSS3
- JavaScript (vanilla)
- Font Awesome (CDN)
- Google Fonts (CDN)

## Compatibilite

- Navigateurs modernes recommandes : Chrome, Edge, Firefox.
- Resolution cible : desktop et mobile.
- Connexion internet requise pour charger les ressources CDN (fonts et icones).

## Organisation du contenu

- `imgs/` : images et illustrations.
- `media/` : assets medias (audio/video/documents selon usage).
- `src/video/` : ressources video source.
- `src/presentaions/` : ressources de presentation (nom de dossier conserve tel quel dans le projet).
- `config/` : fichiers de configuration additionnels.
- `Wpages/` : pages web secondaires et prototypes.

## Deploiement

Ce projet peut etre deployee sur n'importe quel hebergement statique.

Exemples :

- GitHub Pages
- Netlify
- Vercel (mode statique)
- Serveur Apache/Nginx classique

Principe : publier le contenu du dossier racine avec `index.html` comme point d'entree.

## FAQ

Q: Faut-il installer Node.js pour lancer le projet ?

R: Non. Le projet fonctionne sans build, directement dans le navigateur (ou via un petit serveur local).

Q: Pourquoi certaines ressources ne se chargent pas hors ligne ?

R: Les polices et icones charges via CDN necessitent internet. Vous pouvez les remplacer par des fichiers locaux si besoin.

Q: Peut-on brancher un backend plus tard ?

R: Oui. La structure actuelle peut evoluer vers une architecture frontend + API.

## Depannage

- Si la page s'affiche mal, verifier que tous les chemins de fichiers sont valides.
- Si les icones n'apparaissent pas, verifier l'acces au CDN Font Awesome.
- Si les polices ne se chargent pas, verifier l'acces au CDN Google Fonts.
- Si l'ouverture directe du fichier HTML pose probleme, demarrer un serveur local (`python -m http.server 8080`).

## Roadmap (proposition)

- Ajouter une architecture frontend modulaire.
- Connecter les contenus a une API backend.
- Mettre en place un systeme d'authentification.
- Ajouter des tests de non-regression UI.

## Contribution

Les contributions sont bienvenues.

1. Fork du projet
2. Creation d'une branche de fonctionnalite
3. Commit des modifications
4. Ouverture d'une pull request

Bonnes pratiques recommandees :

- Garder les commits atomiques et explicites.
- Verifier l'affichage desktop et mobile avant PR.
- Eviter les regressions visuelles sur `index.html` et les pages dans `Wpages/`.

## Licence

Ce projet est distribue sous tri-licence au choix :

- GPL-3.0-or-later
- MIT
- Apache-2.0

Voir les fichiers `LICENCE`, `LICENSE-GPL-3.0-or-later`, `LICENSE-MIT` et `LICENSE-APACHE-2.0`.
