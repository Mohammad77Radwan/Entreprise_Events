# Système de Gestion des Événements d'Entreprise

##  Table des Matières
- [Fonctionnalités](#-fonctionnalités)
- [Technologies](#-technologies)
- [Installation](#-installation)
- [Structure du Projet](#-structure-du-projet)
- [Modèle de Données](#-modèle-de-données)
- [Sécurité](#-sécurité)
- [Captures d'Écran](#-captures-décran)
- [Licence](#-licence)

##  Fonctionnalités

### Gestion des Utilisateurs
- **3 Rôles** : Administrateur, Organisateur, Participant
- Authentification sécurisée
- Profils personnalisés

### Gestion des Événements
- Création/modification/suppression
- Calendrier des événements
- Capacité maximale de participants
- 4 Statuts : Planifié/En cours/Terminé/Annulé

### Réservations
- Système d'inscription aux événements
- Gestion des listes d'attente
- Export des participants (CSV)

### Tableau de Bord
- Statistiques de participation
- Vue synthétique des événements

##  Technologies

### Backend
- PHP 8.2 (Architecture MVC)
- MySQL 8.0 (Base de données)
- PDO (Accès sécurisé aux données)

### Frontend
- Bootstrap 5 (Interface responsive)
- JavaScript (Interactions dynamiques)
- Font Awesome (Icônes)

### Infrastructure
- Docker (Conteneurisation)
- Apache (Serveur web)
- PHPMyAdmin (Gestion de la base)

## Installation

### Prérequis
- Docker et Docker Compose
- Git 

### Instructions
```bash
# 1. Cloner le dépôt
git clone https://github.com/votre-repo/entreprise_events.git
cd entreprise_events
```
# 2. Démarrer les conteneurs
docker-compose up -d --build

# 3. Accéder à l'application
http://localhost:8000


### Comptes de Test

| Rôle           | Identifiants     | Accès                      |
| -------------- | ---------------- | -------------------------- |
| Administrateur | admin / password | Toutes les fonctionnalités |
| Organisateur   | org1 / password  | Gestion événements         |
| Participant    | part1 / password | Réservations               |


### Structure du Projet

```text
entreprise_events/
├── docker/
│   ├── mysql/init.sql         # Schéma SQL initial
│   └── php/
│       ├── Dockerfile         # Configuration PHP
│       └── security-headers.conf
├── src/
│   ├── config/               # Fichiers de configuration
│   ├── controllers/          # Contrôleurs MVC
│   ├── models/               # Modèles PDO
│   ├── views/                # Templates
│   ├── assets/               # CSS/JS/images
│   └── index.php             # Front Controller
├── docs/
│   └── documentation-technique.md
└── docker-compose.yml        # Configuration Docker
```

### Structure complete du Projet

```text

entreprise_events/
├── .gitignore
├── docker-compose.yml
├── README.md
├── docs/
│   ├── documentation-technique.md
│   ├── MCD.png
│   └── wireframes/
├── src/
│   ├── config/
│   │   ├── database.php
│   │   └── constants.php
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── EventController.php
│   │   ├── HomeController.php
│   │   ├── OrganizerController.php
│   │   ├── ParticipantController.php
│   │   └── ReservationController.php
│   ├── models/
│   │   ├── Database.php
│   │   ├── Event.php
│   │   ├── Organizer.php
│   │   ├── Participant.php
│   │   ├── Reservation.php
│   │   └── User.php
│   ├── views/
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   ├── events/
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   ├── index.php
│   │   │   └── show.php
│   │   ├── organizers/
│   │   │   ├── index.php
│   │   │   └── show.php
│   │   ├── participants/
│   │   │   ├── index.php
│   │   │   └── show.php
│   │   ├── reservations/
│   │   │   ├── create.php
│   │   │   └── index.php
│   │   ├── partials/
│   │   │   ├── footer.php
│   │   │   ├── header.php
│   │   │   └── navbar.php
│   │   ├── layouts/
│   │   │   └── main.php
│   │   └── home.php
│   ├── utils/
│   │   ├── Auth.php
│   │   ├── Validator.php
│   │   └── helpers.php
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css
│   │   ├── js/
│   │   │   └── main.js
│   │   └── images/
│   └── index.php
└── docker/
    ├── mysql/
    │   └── init.sql
    └── php/
        └── Dockerfile
```


### Modèle de Données
```mermaid
erDiagram
    USER {
        int id PK
        string username
        string email
        string password
        string role
    }
    USER ||--o{ ORGANIZER : "1-1"
    USER ||--o{ PARTICIPANT : "1-1"
    
    ORGANIZER {
        int id PK
        int user_id FK
        string first_name
        string last_name
        string phone
        string department
    }
    
    PARTICIPANT {
        int id PK
        int user_id FK
        string first_name
        string last_name
        string email
        string phone
        string department
    }
    
    EVENT {
        int id PK
        int organizer_id FK
        string title
        text description
        datetime start_datetime
        datetime end_datetime
        string location
        int max_participants
        string status
    }
    
    RESERVATION {
        int id PK
        int event_id FK
        int participant_id FK
        datetime reservation_date
        string status
        text comments
    }
    
    EVENT ||--o{ RESERVATION : "1-N"
    PARTICIPANT ||--o{ RESERVATION : "1-N"
 ```



## Sécurité

### Mesures Implémentées

**Protection des données :**

* Préparation des requêtes SQL (`PDO`)
* Échappement HTML (`htmlspecialchars`)

**Authentification :**

* Hachage bcrypt (`password_hash`)
* Gestion des sessions

**En-têtes HTTP :**

* CSP (Content Security Policy)
* X-XSS-Protection



## License
MIT - See [LICENSE](LICENSE) file


---

### 🛠️ Développé par  
**RADWAN Mohammad**

### 🎓 Dans le cadre du  
**BTS SIO – Option SLAM**

### 📅 Année  
**2025**

---
