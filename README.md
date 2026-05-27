## Objectif de l'application
L’application a pour objectif de centraliser et faciliter la gestion du planning des interventions pédagogiques d’une promotion de licence. Elle est destinée à l’équipe pédagogique et administrative chargée d’organiser les enseignements, de planifier les cours et de coordonner les intervenants qui interviennent tout au long de l’année scolaire.
Elle permet notamment de :

● Structurer l’ensemble des enseignements sous forme de blocs, modules et périodes de cours ;

● Gérer les intervenants et leurs disponibilités ;

● Planifier les différentes interventions (cours, ateliers, projets, conférences, évaluations, etc.) sur l’année ;

● Offrir une vision claire, cohérente et mise à jour du planning de la seule promotion concernée ;

● Éviter les conflits d’horaires ou les chevauchements d’interventions ;

● Remplacer ou compléter les outils traditionnels (tableurs, échanges e-mail) par une solution centralisée, fiable et plus efficace.
L’application devient ainsi un outil de référence unique pour organiser le planning de la promotion, améliorer la coordination entre les intervenants et faciliter le suivi de l’année scolaire pour l’équipe pédagogique.

---


## Contexte
Ce projet a été réalisé en groupe de cinq personnes dans le cadre de notre formation, avec l'aide de notre formateur. C'était une bonne occasion de travailler en équipe sur un projet plus grand que ce que nous avions l'habitude de faire, en apprenant à nous organiser et à communiquer ensemble.
Nous avons utilisé Symfony pour la partie back-end et Tailwind CSS pour le design, deux technologies que nous découvrions. Cela nous a permis d'apprendre de nouvelles choses tout en les appliquant directement sur un projet concret.

---

## Organisation de l'équipe

### Membres
- Benkherouf Sofiane
- Kouadria Redwane
- Godard Valentin
- Pereira Marco
- Ghazzaoui Reyan

---

## Méthode de travail

### Organisation en sprints
Nous avons adopté une organisation **agile par sprints**, où chaque sprint 
correspondait à un ensemble de fonctionnalités à livrer. À chaque sprint, 
chaque membre de l'équipe se voyait attribuer **une fonctionnalité distincte**, 
garantissant une répartition équitable du travail et une montée en compétences 
individuelle sur l'ensemble du projet.

---

### Répartition des tâches
Les fonctionnalités du projet ont été découpées en tâches indépendantes 
correspondant aux grandes sections de l'application :
- Calendrier & gestion des interventions
- Corps enseignant & fiches enseignants
- Modules & blocs d'enseignement
- Années scolaires & semaines de cours
- Types d'intervention & paramétrage

Chaque développeur était **responsable de bout en bout** de sa fonctionnalité : 
conception de la route Symfony, du contrôleur, des entités Doctrine, du template 
Twig et des validations associées.

---

### Gestion de projet avec GitHub
Nous avons utilisé **GitHub** comme outil central de collaboration :
- **Issues** : chaque fonctionnalité était tracée sous forme de ticket
- **Branches** : une branche par fonctionnalité (`feature/nom-fonctionnalite`)
- **Pull Requests** : toute intégration sur `main` passait par une PR relue 
  par au moins un autre membre
- **Backlog** : découpage des user stories et suivi de l'avancement

---

### Communication
Les échanges quotidiens se faisaient en présentiel et à distance, avec des 
points réguliers en équipe pour synchroniser les avancées, pour la communucation a distance elle se faisait a distance.

---

### Technologies : Tailwind, PHP, Symfony, JavaScript, mySQL et GIT.

---

### Installation du projet

1.PHP

- **Tout d'abord, télécharger et installer php version 8.4 https://www.php.net/downloads.php?os=windows&osvariant=windows-downloads&version=8.4**

2.Symfony

- **Télécharger et installer Symfony via le site https://symfony.com/download**

3.Composer

- **Télécharger et installer Composer https://getcomposer.org/download/**

4.Cloner le projet

- **git clone https://github.com/marc0prra/GestionLicence.git
cd GestionLicence**

5.Installer les dépendances

- **composer install**

6.Configurer l'environnement

- **modifier le fichier .env.local avec les variables pour la connexion à la base de données**

7.Créer la base de données

- **Créer la base de données
php bin/console doctrine:database:create**

- **Exécuter les migrations
php bin/console doctrine:migrations:migrate**

- **Charger les données de test (fixtures)
php bin/console doctrine:fixtures:load**

8.Démarrer le serveur

- **symfony serve**

---

## MEA de la base de donnée
<img width="618" height="360" alt="image" src="https://github.com/user-attachments/assets/a1dc614b-79fc-411f-9ceb-feb9044e03e5" />

### Guide d'utilisation : [Guide d'utilisation.pdf](https://github.com/user-attachments/files/25743798/Guide.d.utilisation.pdf)

### Cahier des charges : [Gestion_licence.pdf](https://github.com/user-attachments/files/25743800/Gestion_licence.pdf)
