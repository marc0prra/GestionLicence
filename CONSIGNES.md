# Sujet d'Examen Blanc : Gestion des indisponibilités du corps enseignant

## Contexte de l'évolution

> Après la première année d'utilisation de l'application, l'équipe pédagogique fait part d'un manquement 
> dans le cahier des charges initial. Actuellement, la page "Modules" liste bien les différents modules regroupés 
> par bloc d'enseignement. Cependant, il est impossible de savoir à quel moment de l'année scolaire 
> ces modules doivent être dispensés (Semestre 1, Semestre 2, etc.). Pour clarifier la lecture du programme, 
> l'école souhaite créer une notion de "Semestre" et l'associer aux modules.

## Travail à réaliser

> Ces semestres doivent être administrables dans une nouvelle table de la base de données. 
> On y trouvera simplement un libellé, par exemple les valeurs suivantes : Semestre 1, Semestre 2, Semestre 3. 
> Lors de l'ajout ou de la modification de la fiche d'un module, un champ de type liste déroulante (obligatoire) devra permettre de sélectionner le semestre concerné. 
> Cette information devra ensuite être affichée de manière très lisible (par exemple avec un badge Bootstrap/Tailwind) à côté du nom du module sur la page listant tous les modules. 
> Enfin, pour faciliter la recherche, un filtre devra être ajouté en haut de la page des modules pour n'afficher que les enseignements d'un semestre spécifique.

## Production attendue 

- Nouvelle version fonctionnelle de l’application intégrant la nouvelle demande d’évolution.
- Mise à jour des documentations :
  - [x] Documentation technique
  - [x] Documentation utilisateur

    
## Pour récupérer le projet 

1) Dans le répertoire de votre projet, ouvrez un terminal
2) Ajouter le serveur distant du projet :

``bash
git remote add examen-blanc https://XXXX (remplacez par l'URL du projet)
git fetch examen-blanc
git pull examen-blanc main
git add .
git commit -m "Récupération du projet pour l'examen blanc"
git push examen-blanc main
```

3) Vous pouvez maintenant travailler sur votre projet en local, 
puis pousser vos modifications sur le serveur distant "examen-blanc" pour que nous puissions les évaluer.

> [!IMPORTANT]  
> Si vous ne séparez pas votre travail du commit initial, il sera impossible de faire la distinction entre les modifications apportées pour l'examen blanc et le code initial.
> La note sera donc affectée à 0/20, même si vous avez réalisé une bonne partie du travail demandé.
