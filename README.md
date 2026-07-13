# ✈️ TravelDream — Plateforme Agence de Voyage

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Python](https://img.shields.io/badge/Python-3.x-3776AB?style=for-the-badge&logo=python&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

> Application web complète pour une agence de voyage avec système de
> réservation en ligne, paiement sécurisé et chatbot IA Python intégré.

---

## 📸 Aperçu

### Page d'accueil
- Hero slider avec photos de destinations
- Recherche rapide par destination, type, date, budget
- Offres à la une
- Vidéos publicitaires
- Statistiques et témoignages

### Espace Client
- Interface moderne avec chatbot IA
- Réservation et paiement en ligne
- Suivi des réservations en temps réel

### Espace Admin
- Dashboard avec statistiques en temps réel
- Gestion complète des offres, réservations, clients

---

## ✨ Fonctionnalités complètes

### 👤 Espace Client
| Fonctionnalité | Description |
|---|---|
| Inscription / Connexion | Authentification sécurisée avec rôle automatique |
| Offres de voyage | Filtrage par destination, type, prix, date |
| Réservation | Formulaire avec calcul de prix en temps réel |
| Paiement | Paiement simulé Stripe sécurisé |
| Suivi réservations | Statut en attente / confirmée / annulée |
| Profil | Modification + upload photo de profil |
| Chatbot IA | Assistant Python disponible 24h/24 |
| Notifications | Système de notifications intégré |

### 🛠️ Espace Admin
| Fonctionnalité | Description |
|---|---|
| Dashboard | Stats en temps réel + graphiques |
| Gestion offres | CRUD + upload images + activation |
| Slides & Vidéos | Gestion médias publicitaires |
| Réservations | Confirmer / Annuler + menu 3 points |
| Clients | Bloquer / Supprimer + voir profils |
| Paiements | Historique des transactions |
| FAQ Chatbot | Gérer la base de connaissances IA |
| Notifications | Envoyer à tous les clients |

---

## 🛠️ Stack Technique

### Backend
- **Laravel 12** — Framework PHP MVC
- **PHP 8.2** — Langage serveur
- **MySQL 8.0** — Base de données relationnelle
- **Laravel Breeze** — Authentification

### Frontend
- **Bootstrap 5.3** — Framework CSS responsive
- **Bootstrap Icons 1.11** — Bibliothèque d'icônes
- **Google Fonts** — Typographie (Inter, DM Sans, Playfair Display)
- **Blade Templates** — Moteur de templates Laravel

### Chatbot IA
- **Python 3.x** — Langage du chatbot
- **Flask** — API REST Python
- **Flask-CORS** — Gestion des origines croisées
- **TF-IDF + Cosine Similarity** — Algorithme NLP maison

### Outils
- **XAMPP** — Environnement local (Apache + MySQL)
- **Composer** — Gestionnaire de dépendances PHP
- **Git** — Contrôle de version

---

## 📦 Installation complète

### Prérequis obligatoires
- ✅ XAMPP installé (PHP 8.2 + MySQL)
- ✅ Composer installé
- ✅ Python 3.x installé
- ✅ Git installé

### Étape 1 — Cloner le projet

```bash
git clone https://github.com/TON_USERNAME/agence-voyage.git
cd agence-voyage
```

### Étape 2 — Installer les dépendances PHP

```bash
composer install
```

### Étape 3 — Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### Étape 4 — Configurer la base de données

Ouvre `.env` et modifie :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agence_voyage
DB_USERNAME=root
DB_PASSWORD=
```

### Étape 5 — Créer la base de données

Ouvre phpMyAdmin (`http://localhost/phpmyadmin`) et crée une base :
```
Nom : agence_voyage
Interclassement : utf8mb4_unicode_ci
```

### Étape 6 — Lancer les migrations

```bash
php artisan migrate:fresh --seed
```

Cela crée toutes les tables et insère :
- ✅ Compte admin (admin@gmail.com / admin123)
- ✅ 5 offres de démonstration
- ✅ FAQs pour le chatbot

### Étape 7 — Lien de stockage

```bash
php artisan storage:link
```

### Étape 8 — Installer les dépendances Python

```bash
cd chatbot-python
pip install flask flask-cors
cd ..
```

---

## 🚀 Lancement du projet

### Terminal 1 — Serveur Laravel

```bash
cd agence-voyage
php artisan serve
```

➡️ Application : **http://127.0.0.1:8000**

### Terminal 2 — Chatbot IA Python

```bash
cd agence-voyage/chatbot-python
python chatbot.py
```

➡️ Chatbot API : **http://localhost:5000**
➡️ Test santé : **http://localhost:5000/health**

---

## 🔑 Comptes de démonstration

### Compte Administrateur
```
URL      : http://127.0.0.1:8000/login
Email    : admin@gmail.com
Password : admin123
Accès    : /admin/dashboard
```

### Compte Client
```
URL      : http://127.0.0.1:8000/register
→ Créez votre propre compte
→ Rôle "client" attribué automatiquement
```

---

## 📁 Structure du projet

```
agence-voyage/
│
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── 📁 Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── OffreAdminController.php
│   │   │   │   ├── ReservationAdminController.php
│   │   │   │   ├── UtilisateurController.php
│   │   │   │   ├── PaiementAdminController.php
│   │   │   │   ├── FaqController.php
│   │   │   │   ├── NotificationAdminController.php
│   │   │   │   └── MediaController.php
│   │   │   ├── 📁 Auth/
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   └── RegisteredUserController.php
│   │   │   ├── HomeController.php
│   │   │   ├── OffreController.php
│   │   │   ├── ReservationController.php
│   │   │   ├── PaiementController.php
│   │   │   ├── ProfilController.php
│   │   │   └── ChatbotController.php
│   │   └── 📁 Middleware/
│   │       ├── AdminMiddleware.php
│   │       ├── ClientMiddleware.php
│   │       └── CheckUserActif.php
│   └── 📁 Models/
│       ├── User.php
│       ├── Offre.php
│       ├── Reservation.php
│       ├── Paiement.php
│       ├── Media.php
│       ├── ImageOffre.php
│       ├── ChatbotFaq.php
│       └── NotificationVoyage.php
│
├── 📁 chatbot-python/
│   ├── chatbot.py          ← Chatbot IA (Flask + TF-IDF)
│   └── requirements.txt
│
├── 📁 database/
│   ├── 📁 migrations/
│   │   ├── create_users_table.php
│   │   ├── create_offres_table.php
│   │   ├── create_images_offres_table.php
│   │   ├── create_reservations_table.php
│   │   ├── create_paiements_table.php
│   │   ├── create_chatbot_faqs_table.php
│   │   ├── create_notifications_voyages_table.php
│   │   └── create_medias_table.php
│   └── 📁 seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminSeeder.php
│       ├── OffresSeeder.php
│       └── ChatbotFaqSeeder.php
│
├── 📁 resources/views/
│   ├── 📁 layouts/
│   │   ├── app.blade.php       ← Layout client
│   │   └── admin.blade.php     ← Layout admin
│   ├── 📁 auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── 📁 admin/
│   │   ├── dashboard.blade.php
│   │   ├── 📁 offres/
│   │   ├── 📁 reservations/
│   │   ├── 📁 utilisateurs/
│   │   ├── 📁 paiements/
│   │   ├── 📁 faqs/
│   │   ├── 📁 notifications/
│   │   └── 📁 medias/
│   ├── 📁 client/
│   │   ├── home.blade.php
│   │   ├── 📁 offres/
│   │   ├── 📁 reservations/
│   │   ├── 📁 paiements/
│   │   └── 📁 profil/
│   └── welcome.blade.php
│
├── 📁 routes/
│   ├── web.php                 ← Toutes les routes
│   └── auth.php
│
├── .env.example                ← Template configuration
├── .gitignore
├── README.md
└── composer.json
```

---

## 🗄️ Schéma de la base de données

```
users ──────────┬──< reservations >──── offres
                │          │
                │          └──< paiements
                │
                └──< notifications_voyages

offres ──────────< images_offres
medias (slides & videos) — indépendant
chatbot_faqs — indépendant
```

### Tables

| Table | Colonnes principales |
|---|---|
| `users` | name, email, password, role, actif, photo |
| `offres` | titre, destination, pays, prix, statut, featured |
| `images_offres` | offre_id, image, ordre |
| `reservations` | user_id, offre_id, reference, statut, prix_total |
| `paiements` | reservation_id, transaction_id, montant, statut |
| `medias` | titre, fichier, type (slide/video), actif |
| `chatbot_faqs` | question, reponse, mots_cles, actif |
| `notifications_voyages` | user_id, titre, message, lue |

---

## 🤖 Chatbot IA — Fonctionnement

### Architecture

```
Utilisateur tape une question
         ↓
Laravel reçoit via POST /chatbot/message
         ↓
Laravel appelle Python Flask POST /chat
         ↓
Python analyse avec TF-IDF + Cosine Similarity
         ↓
Python cherche dans 19 catégories de connaissances
         ↓
Réponse renvoyée à Laravel → affichée dans le chat
```

### Catégories de réponses
```
✅ Salutations et aide générale
✅ Comment réserver un voyage
✅ Annulation et remboursement
✅ Paiement et tarifs
✅ Destinations générales
✅ Paris — France
✅ Maldives
✅ Istanbul — Turquie
✅ Rome — Italie
✅ Dubai — Émirats
✅ Safari Kenya
✅ Bali — Indonésie
✅ Contact et support
✅ Visa et documents
✅ Assurance voyage
✅ Tarifs famille et enfants
✅ Hébergement et hôtels
✅ Remerciements
✅ Au revoir
```

### Tester le chatbot directement

```bash
# Vérifier que le chatbot tourne
curl http://localhost:5000/health

# Envoyer une question
curl -X POST http://localhost:5000/chat \
  -H "Content-Type: application/json" \
  -d "{\"message\": \"Comment reserver un voyage ?\"}"
```

---

## 🔒 Sécurité

- 🔐 Authentification via middleware Laravel
- 🛡️ Rôles : `admin` et `client` séparés
- 🚫 Compte bloqué → déconnexion automatique
- 🔒 CSRF sur tous les formulaires
- 🔑 Mots de passe hashés avec bcrypt
- 📁 Fichier `.env` jamais uploadé sur GitHub

---

## 🎨 Design

- **Police Admin** : Inter (Google Fonts)
- **Police Client** : DM Sans + Playfair Display
- **Couleur Admin** : Vert (#22C55E)
- **Couleur Client** : Bleu ciel (#0EA5E9)
- **Style** : Cards modernes, badges pill, animations hover

---



## 👨‍💻 Auteur

**Sami Awled Massoud**

- GitHub : https://github.com/semiawledmassoud
- Email : samibnmassoud@gmail.com

---

## 📄 Licence

Ce projet est sous licence **MIT** — voir le fichier [LICENSE](LICENSE) pour les détails.

---

*Développé avec ❤️ pour le cours de développement web*