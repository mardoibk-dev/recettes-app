# 🍽 Plateforme de Recettes

Application web de gestion de recettes développée avec **Laravel** et **Bootstrap**.

## ✨ Fonctionnalités
- Authentification utilisateur
- Création, modification et suppression de recettes
- Upload d’images
- Ajout aux favoris
- Dashboard utilisateur
- Interface moderne et responsive

## 🛠 Technologies
- Laravel
- PHP 8+
- Bootstrap 5
- MySQL
- Blade

## 🚀 Installation

```bash
git clone (https://github.com/mardoibk-dev/recettes-app.git)
cd recettes-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
