# 🧘‍♂️ Karmalizer - Projet Symfony

Ce projet est une application Symfony permettant d'analyser des contenus, générer des infractions, et leur associer des missions de rédemption avec des récompenses.

## 🚀 Prérequis

Assure-toi d'avoir installé sur ta machine :

- [PHP 8.2+](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js et npm](https://nodejs.org/)
- [Docker & Docker Compose](https://www.docker.com/)

---

## 📦 Installation

1. Clone le projet :

```bash
git clone https://github.com/ton-utilisateur/ton-projet.git](https://github.com/rosves/Karmalizer.git
cd ton-projet
```

2. Installe les dépendances PHP :

```bash
composer install
```

3. Installe les dépendances front-end (Webpack/Tailwind) :

```bash
npm install
```

4. Compile les assets :

```bash
npm run build     # ou `npm run dev` ou `npm run watch`
```

---

## 🐳 Lancer la base de données avec Docker

1. Démarre un conteneur PostgreSQL (ou MySQL selon ta config) :

**Exemple pour PostgreSQL :**

Crée un fichier `docker-compose.yml` à la racine (si absent) :

```yaml
version: '3.8'

services:
  database:
    image: postgres:15
    environment:
      POSTGRES_DB: karmalizer
      POSTGRES_USER: symfony
      POSTGRES_PASSWORD: symfony
    ports:
      - "5432:5432"
    volumes:
      - postgres_data:/var/lib/postgresql/data

volumes:
  postgres_data:
```

Puis exécute :

```bash
docker-compose up -d
```

---

## ⚙️ Configuration de l'environnement

1. Copie le fichier `.env` :

```bash
cp .env .env.local
```

2. Adapte ta connexion à la base :

Dans `.env.local` :

```dotenv
DATABASE_URL="postgresql://symfony:symfony@localhost:5432/karmalizer?serverVersion=15&charset=utf8"
```

---

## 🛠️ Création de la base de données

1. Crée la base :

```bash
php bin/console doctrine:database:create
```

2. Génère le schéma :

```bash
php bin/console doctrine:schema:update --force
```

---

## 🌱 Peupler la base avec des données de test (fixtures)

```bash
php bin/console doctrine:fixtures:load
```

## 🔥 Lancer le serveur Symfony

```bash
symfony server:start
```

## 🧪 Vérifier que tout fonctionne

Accède à [http://localhost:8000](http://localhost:8000)

---





