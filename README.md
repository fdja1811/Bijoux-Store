# 💎 Bijoux Store — Site E-Commerce

> **Projet Professionnel Encadré (PPE AP1) - BTS SIO SLAM**

Bienvenue sur le dépôt du projet **Bijoux Store**, un site e-commerce dynamique dédié à la vente de bijoux berbères traditionnels (bagues, colliers, bracelets, boucles d'oreilles et parures).

---

## 📌 Présentation du Projet

Le projet **Bijoux Store** répond au besoin de mettre en ligne une boutique permettant aux clients de consulter et d'acheter des bijoux en ligne, tout en offrant une gestion sécurisée des comptes utilisateurs.

### 🛠️ Fonctionnalités Principales

- **Gestion des Utilisateurs :**
  - Inscription sécurisée avec règles de complexité du mot de passe en temps réel.
  - Authentification (Connexion / Déconnexion) sécurisée via hachage Bcrypt.
  - Espace "Mon Compte" permettant la modification du mot de passe avec contrôle de l'historique.
- **Catalogue & Boutique :**
  - Affichage dynamique du catalogue de 50 produits répartis en 5 catégories.
  - Filtrage interactif par catégorie (Bagues, Colliers, Bracelets, Boucles d'oreilles, Parures).
  - Gestion des ruptures de stock.
  - Modale (Lightbox) au clic pour l'agrandissement des visuels.
- **Gestion du Panier :**
  - Ajout d'articles au panier et mise à jour automatique des quantités.
  - Calcul dynamique du sous-total par article et du total général de la commande.
  - Options de suppression d'un article ou de vidage complet du panier.

---

## 🧰 Technologies Utilisées

| Technologie | Rôle |
| :--- | :--- |
| **PHP 8.x** | Logic Métier, gestion du back-end et des sessions |
| **MySQL 9.x** | Base de données relationnelle |
| **HTML5 / CSS3** | Structure et mise en forme responsive |
| **JavaScript** | Interactions dynamiques côté client (filtres, lightbox, validations) |
| **WAMP Server** | Environnement de développement local Apache/MySQL |

---

## 📂 Structure du Projet

```text
AP1/
├── index.php                # Page d'accueil du site
├── ppe.sql                  # Script d'importation de la base de données
├── components/              # Éléments de structure réutilisables
│   ├── header.php           # En-tête avec barre de navigation
│   └── footer.php           # Pied de page
├── css/                     # Feuilles de style CSS
│   ├── boutique.css
│   ├── forms.css
│   ├── index.css
│   └── panier.css
├── images/                  # Catalogue des images de produits (50 visuels)
├── js/                      # Scripts de validation et d'interaction
└── php/                     # Scripts back-end et traitement des formulaires
    ├── db.php               # Connexion centralisée à la base de données (PDO)
    ├── connexion.php
    ├── inscription.php
    ├── produit.php
    ├── panier.php
    └── changer_mdp.php
