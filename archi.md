# Architecture et modelisation - SuperEdu

Ce document regroupe les diagrammes demandes pour la plateforme SuperEdu:

1. Cas d utilisation
2. Classe
3. Objets
4. Comportementaux: Sequence et Activite
5. Etude de cas (en fin de document)

## 1) Diagramme des cas d utilisation

```mermaid
flowchart LR
		Etudiant((Etudiant))
		Enseignant((Enseignant))
		Mentor((Mentor IA))
		Admin((Administrateur))

		subgraph SuperEdu
			UC1[Consulter les parcours]
			UC2[Suivre un module]
			UC3[Passer une evaluation]
			UC4[Consulter les conseils IA]
			UC5[Publier du contenu]
			UC6[Suivre la progression]
			UC7[Verifier la sante du systeme]
			UC8[Gerer utilisateurs et droits]
		end

		Etudiant --> UC1
		Etudiant --> UC2
		Etudiant --> UC3
		Etudiant --> UC4
		Enseignant --> UC5
		Enseignant --> UC6
		Admin --> UC7
		Admin --> UC8
		Mentor --> UC4
```

## 2) Diagramme de classes

```mermaid
classDiagram
		class Utilisateur {
			+id: int
			+nom: string
			+email: string
			+role: string
			+authentifier()
		}

		class Etudiant {
			+niveau: string
			+sInscrireParcours()
			+soumettreEvaluation()
		}

		class Enseignant {
			+specialite: string
			+creerModule()
			+publierRessource()
		}

		class Administrateur {
			+gererComptes()
			+consulterStatutSysteme()
		}

		class Parcours {
			+id: int
			+titre: string
			+description: string
			+ajouterModule()
		}

		class Module {
			+id: int
			+titre: string
			+contenu: text
			+publier()
		}

		class Evaluation {
			+id: int
			+type: string
			+scoreMax: int
			+corriger()
		}

		class NodeService {
			+health()
			+ready()
			+status()
		}

		class BackendLaravel {
			+apiHealth()
			+apiCours()
			+apiProgression()
		}

		Utilisateur <|-- Etudiant
		Utilisateur <|-- Enseignant
		Utilisateur <|-- Administrateur
		Parcours "1" o-- "*" Module
		Module "1" o-- "*" Evaluation
		Etudiant "*" --> "*" Parcours : suit
		Enseignant "1" --> "*" Module : publie
		NodeService --> BackendLaravel : sonde
```

## 3) Diagramme d objets

```mermaid
flowchart TD
		E1[etudiant_17:Etudiant\nnom=Amine\nniveau=L2]
		P1[parcours_web:Parcours\ntitre=Developpement Web]
		M1[module_react:Module\netat=publie]
		EV1[quiz_react_01:Evaluation\ntype=QCM]
		ENS1[enseignant_04:Enseignant\nnom=Mme Diallo]
		NS1[node_service_1:NodeService\nport=4000]
		BE1[backend_api_1:BackendLaravel\nport=8000]

		E1 -->|inscrit| P1
		P1 -->|contient| M1
		M1 -->|evalue par| EV1
		ENS1 -->|publie| M1
		NS1 -->|verifie| BE1
```

## 4) Diagrammes comportementaux

### 4.1 Diagramme de sequence

```mermaid
sequenceDiagram
		autonumber
		participant U as Etudiant
		participant F as Frontend React
		participant N as Node Service
		participant B as Backend Laravel

		U->>F: Ouvre le parcours
		F->>N: GET /api/status
		N->>B: GET /api/health
		B-->>N: 200 OK
		N-->>F: status global OK
		F->>B: GET /api/parcours/1/modules
		B-->>F: liste des modules
		F-->>U: Affiche les contenus
```

### 4.2 Diagramme d activite

```mermaid
flowchart TD
		A([Debut]) --> B[Connexion utilisateur]
		B --> C{Role detecte}
		C -->|Etudiant| D[Consulter parcours]
		C -->|Enseignant| E[Publier module]
		C -->|Admin| F[Verifier status plateforme]

		D --> G[Suivre module]
		G --> H[Passer evaluation]
		H --> I[Enregistrer resultat]

		E --> J[Valider contenu]
		J --> K[Publier]

		F --> L[Controler health et ready]

		I --> M([Fin])
		K --> M
		L --> M
```

## 5) Etude de cas (scenario de reference)

### Contexte

Un etudiant se connecte, accede a un parcours, termine un module et passe une evaluation. Le systeme doit verifier la disponibilite technique avant de charger les donnees pedagogiques.

### Objectif

Garantir une experience continue meme en architecture multi-services (frontend, node-service, backend).

### Diagramme de sequence - Etude de cas

```mermaid
sequenceDiagram
		autonumber
		participant U as Etudiant
		participant F as Frontend
		participant N as Node Service
		participant B as Backend

		U->>F: Demande d acces au module React
		F->>N: GET /ready
		N->>B: GET /api/health
		alt Backend disponible
				B-->>N: 200 OK
				N-->>F: READY
				F->>B: GET /api/modules/react
				B-->>F: Contenu du module
				F-->>U: Affichage + lancement evaluation
		else Backend indisponible
				B-->>N: 503 Service Unavailable
				N-->>F: NOT_READY
				F-->>U: Message de maintenance
		end
```

### Resultats attendus

- Disponibilite controlee avant usage metier.
- Degradation maitrisee en cas de panne backend.
- Visibilite operationnelle grace aux endpoints health/ready/status.
