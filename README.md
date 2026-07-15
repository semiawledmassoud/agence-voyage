# ✈️ TravelDream — Plateforme de Gestion d'Agence de Voyage

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Python](https://img.shields.io/badge/Python-3.x-3776AB?style=for-the-badge&logo=python&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

> Application web full-stack développée pour digitaliser la gestion d'une agence de voyage. Elle permet aux clients de consulter les offres, réserver et payer leurs voyages en ligne, tandis que les administrateurs disposent d'un tableau de bord complet pour gérer les offres, les réservations, les paiements et les clients.

---

# 📸 Aperçu

## 🌍 Espace Client

- Consultation des offres de voyage
- Recherche et filtrage
- Réservation en ligne
- Paiement sécurisé
- Historique des réservations
- Gestion du profil
- Chatbot IA

## 🛠️ Espace Administration

- Dashboard avec statistiques
- Gestion des offres
- Gestion des réservations
- Gestion des clients
- Gestion des paiements
- Gestion des médias
- Gestion des FAQ du chatbot

---

# ✨ Fonctionnalités

## 👤 Espace Client

| Fonctionnalité | Description |
|---|---|
| Authentification | Inscription et connexion sécurisées |
| Offres | Consultation et filtrage des voyages |
| Réservation | Réservation avec calcul automatique du prix |
| Paiement | Paiement sécurisé |
| Historique | Suivi des réservations |
| Profil | Modification des informations personnelles |
| Chatbot IA | Assistance disponible 24h/24 |

---

## 👨‍💼 Espace Administration

| Fonctionnalité | Description |
|---|---|
| Dashboard | Statistiques en temps réel |
| Offres | Ajouter, modifier et supprimer des offres |
| Réservations | Confirmer ou annuler les réservations |
| Clients | Gérer les comptes clients |
| Paiements | Suivi des paiements |
| Médias | Gestion des slides et vidéos |
| FAQ | Gestion de la base de connaissances du chatbot |

---

# 🛠️ Stack Technique

## Backend

- Laravel 12
- PHP 8.2
- MySQL
- Laravel Breeze

## Frontend

- Blade
- Bootstrap 5
- HTML5
- CSS3
- JavaScript

## Chatbot IA

- Python 3
- Flask
- Flask-CORS
- TF-IDF
- Cosine Similarity

## Outils

- XAMPP
- Composer
- Git
- GitHub
- Visual Studio Code

---

# 📦 Installation

## Prérequis

- PHP 8.2
- Composer
- Python 3
- MySQL
- Git
- XAMPP

---

## 1. Cloner le projet

```bash
git clone https://github.com/semiawledmassoud/agence-voyage.git

cd agence-voyage
```

---

## 2. Installer les dépendances Laravel

```bash
composer install
```

---

## 3. Configurer l'environnement

```bash
cp .env.example .env

php artisan key:generate
```

Configurer ensuite la base de données dans le fichier `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agence_voyage
DB_USERNAME=root
DB_PASSWORD=
```

---

## 4. Créer la base de données

Créer une base de données nommée :

```
agence_voyage
```

---

## 5. Lancer les migrations

```bash
php artisan migrate:fresh --seed
```

---

## 6. Créer le lien de stockage

```bash
php artisan storage:link
```

---

## 7. Installer les dépendances Python

```bash
cd chatbot-python

pip install flask flask-cors

cd ..
```

---

# 🚀 Lancement

## Terminal 1

```bash
php artisan serve
```

Application disponible sur :

```
http://127.0.0.1:8000
```

---

## Terminal 2

```bash
cd chatbot-python

python chatbot.py
```

API Chatbot disponible sur :

```
http://localhost:5000
```

---

# 📁 Structure du projet

```text
agence-voyage/
│
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── chatbot-python/
├── .env.example
├── composer.json
└── README.md
```

---

# 🤖 Chatbot IA

Le chatbot est développé avec **Python** et **Flask**.

Il utilise l'algorithme **TF-IDF + Cosine Similarity** afin d'analyser les questions des utilisateurs et fournir des réponses pertinentes concernant :

- Réservations
- Destinations
- Paiements
- Visa
- Assurance
- Annulation
- Support client

### Architecture

```
Utilisateur

↓

Laravel

↓

API Flask

↓

TF-IDF + Cosine Similarity

↓

Réponse du chatbot
```

---

# 🔒 Sécurité

- Authentification Laravel Breeze
- Middleware de protection
- Gestion des rôles (Admin / Client)
- Protection CSRF
- Validation des formulaires
- Hashage des mots de passe avec Bcrypt
- Fichier `.env` exclu du dépôt GitHub

---

# 🎨 Interface

- Bootstrap 5
- Responsive Design
- Dashboard moderne
- Interface administrateur
- Interface client intuitive

---

# 👨‍💻 Auteur

**Sami Awled Massoud**

- GitHub : https://github.com/semiawledmassoud
- Portfolio : https://sami-awled-massoud.netlify.app
- LinkedIn : https://www.linkedin.com/in/sami-awled-massoud-b9560a276
- Email : samibnmassoud@gmail.com

---

# 📄 Licence

Ce projet est publié à des fins de démonstration de compétences en développement web full-stack.

---

*Développé avec ❤️ par Sami Awled Massoud.*
