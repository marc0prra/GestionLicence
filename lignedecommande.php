Pour lancer notre projet Symfony il faut mettre cette ligne de commande dans le terminal : symfony new GestionLicence --webapp

Puis il faut d’abord installer le composer : composer install

Pour installer les Form : D’abord avoir les entités pour le créer 

Pour les dataFixtures : composer require --dev orm-fixtures

Création de la base de données : php bin/console doctrine:database:create 

Suppression de la base de données : php bin/console doctrine:database:drop 

Chargement des données de fixtures : php bin/console doctrine:fixtures:load

Création du schéma de la base de données : php bin/console doctrine:schema:create 

Suppression du schéma de la base de données : php bin/console doctrine:schema:drop 

Mise à jour du schéma de la base de données : php bin/console doctrine:schema:update -f

Validation du schéma de la base de données : php bin/console doctrine:schema:validate 

Générer l’entité php : php bin/console make:entity 

Installer tailwind : composer require symfonycasts/tailwind-bundle 

Configurer les fichiers : php -d memory_limit=-1 bin/console tailwind:build

Générer le css : php bin/console tailwind:build --watch 

Générer un formulaire : php bin/console make:form