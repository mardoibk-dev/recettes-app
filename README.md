 🍽 Plateforme de Recettes

Application web moderne de gestion de recettes culinaires développée avec Laravel.

## ✨ Fonctionnalités Principales
- ✅ **Authentification** complète (inscription/connexion)
- ✅ **Gestion CRUD** des recettes (créer, lire, modifier, supprimer)
- ✅ **Système de favoris** avec animations
- ✅ **Upload d'images** avec drag & drop
- ✅ **Dashboard** personnel avec statistiques
- ✅ **Interface responsive** et moderne
- ✅ **Filtrage** par difficulté

## 🛠 Technologies Utilisées
- **Backend** : Laravel, PHP 8.2+
- **Frontend** : Bootstrap 5, JavaScript, CSS3
- **Base de données** : MySQL / SQLite
- **Autres** : Blade Templates, Eloquent ORM

## 🚀 Installation Rapide

```bash
# 1. Cloner le projet
git clone https://github.com/TON_USERNAME/recettes-app.git
cd recettes-app

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données (modifier .env)
# DB_CONNECTION=mysql
# DB_DATABASE=recettes

# 5. Lancer les migrations
php artisan migrate

# 6. Créer le lien de stockage
php artisan storage:link

# 7. Démarrer le serveur
php artisan serve
```

## 📁 Structure des Fichiers
```
app/
├── Models/           # Modèles (Recipe, User, Favorite)
├── Http/Controllers/ # Contrôleurs
└── View/Components/  # Composants Blade

resources/views/
├── layouts/          # Templates (app.blade.php)
├── recipes/          # Vues des recettes
└── dashboard.blade.php

database/migrations/  # Migrations de base de données
```

## 🔧 Configuration Basique
```env
# Fichier .env
APP_NAME="Recettes App"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recettes
DB_USERNAME=root
DB_PASSWORD=
```

## 📸 Captures d'Écran
**Dashboard** : Interface personnelle avec statistiques  
**Liste des recettes** : Grille responsive avec filtres  
**Formulaire** : Création/édition avec validation  
**Favoris** : Collection personnelle avec badges  

## 🎯 Pages Principales
- `/dashboard` - Tableau de bord utilisateur
- `/recipes` - Liste de toutes les recettes
- `/recipes/create` - Ajouter une recette
- `/recipes/{id}/edit` - Modifier une recette
- `/favorites` - Recettes favorites

## 🔒 Sécurité
- Authentification Laravel Fortify
- Protection CSRF intégrée
- Validation des données côté serveur
- Hash des mots de passe (bcrypt)
- Middleware d'authentification

## 📱 Design Responsive
- Mobile-first approach
- Navigation adaptative
- Images responsives
- Touch-friendly interfaces

## 🐛 Dépannage

### Problèmes Courants
1. **Erreur de connexion à la base** : Vérifiez les credentials dans `.env`
2. **Images non affichées** : Exécutez `php artisan storage:link`
3. **Erreur 419** : Videz le cache avec `php artisan cache:clear`

### Commandes Utiles
```bash
# Réinitialiser la base
php artisan migrate:fresh

# Générer des données de test
php artisan db:seed

# Vider les caches
php artisan optimize:clear
```

## 🤝 Contribution
1. Fork le projet
2. Créer une branche (`git checkout -b feature/nouvelle-fonctionnalite`)
3. Commit (`git commit -m 'Ajout fonctionnalité'`)
4. Push (`git push origin feature/nouvelle-fonctionnalite`)
5. Ouvrir une Pull Request

## 📄 Licence
MIT - Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 📞 Contact
**Auteur** : Mardochée OLAYE
**Email** : Mardoibk@gmail.com  
**GitHub** : https://github.com/mardoibk-dev


