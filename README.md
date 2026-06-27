# 💰 Gestion des Bénéfices Vendeurs

Application web développée avec Laravel permettant aux vendeurs de suivre leurs produits, leurs ventes et de visualiser leurs bénéfices sous forme de graphiques.

---

## 🚀 Fonctionnalités

- Inscription et connexion sécurisée par vendeur
- Ajout de produits avec prix d'achat et prix de vente
- Enregistrement des ventes par carton
- Calcul automatique des bénéfices
- Dashboard avec graphiques (courbe d'évolution + graphique par produit)
- Chaque vendeur voit uniquement ses propres données

---

## 🛠️ Technologies utilisées

- **Backend** : Laravel 8 (PHP 7.4)
- **Base de données** : SQLite
- **Frontend** : Blade + Bootstrap 5
- **Graphiques** : Chart.js

---

## ⚙️ Installation locale

### Prérequis
- PHP 7.4+
- Composer
- Node.js & npm
- Git

### Étapes

```bash
# Cloner le dépôt
git clone https://github.com/TON_USERNAME/site-benefices.git
cd site-benefices

# Installer les dépendances PHP
composer install

# Installer les dépendances JS
npm install && npm run dev

# Copier le fichier d'environnement
cp .env.example .env

# Configurer la base de données dans .env
DB_CONNECTION=sqlite

# Créer le fichier SQLite
touch database/database.sqlite

# Générer la clé de l'application
php artisan key:generate

# Lancer les migrations
php artisan migrate

# Démarrer le serveur
php artisan serve
```

L'application sera disponible sur `http://127.0.0.1:8000`

---

## 📁 Structure du projet
app/

├── Http/Controllers/

│   ├── DashboardController.php

│   ├── ProductController.php

│   └── SaleController.php

├── Models/

│   ├── Product.php

│   ├── Sale.php

│   └── User.php

database/

├── migrations/

│   ├── create_products_table.php

│   └── create_sales_table.php

resources/views/

├── layouts/

├── products/

├── sales/

└── dashboard.blade.php

## 📊 Modèle de données

| Table | Champs principaux |
|---|---|
| `users` | id, name, email, password |
| `products` | id, user_id, nom, prix_achat, prix_vente |
| `sales` | id, product_id, quantite_cartons, benefice_calcule, date_vente |

---

## 🔐 Sécurité

- Authentification complète (inscription, connexion, déconnexion)
- Chaque vendeur accède uniquement à ses propres données
- Protection CSRF sur tous les formulaires
- Validation des données côté serveur

---

## 🌐 Déploiement

Ce projet est déployable sur **Railway.app** :

1. Créer un compte sur railway.app
2. Connecter ton dépôt GitHub
3. Configurer les variables d'environnement
4. Déployer en un clic

---

## 👨‍💻 Auteur

Développé par **[Ton Nom]**

---

## 📄 Licence

Ce projet est sous licence MIT.
