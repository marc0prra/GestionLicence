╔══════════════════════════════════════════════════════════╗
║       BROUILLON E6 — BTS SIO SLAM — Symfony 7           ║
║       Plan à suivre dans l'ordre                        ║
╚══════════════════════════════════════════════════════════╝


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 1 — Créer la nouvelle entité
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  php bin/console make:entity NomEntite

  → Déclarer tous les champs (nom, type, nullable)
  → Si relation vers entité existante :
       type: relation → ManyToOne → NomEntiteParente
       nullable: no
       Ajouter la relation inverse ? → yes

  Exemple :
    New property name > fullName | type: string | length: 255 | nullable: no
    New property name > course   | type: relation → ManyToOne → Course | nullable: no
    Add inverse side on Course ? → yes | field name: absences | orphanRemoval: yes


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 2 — Ajouter les validations dans l'entité
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  → Ouvrir src/Entity/NomEntite.php
  → Ajouter au-dessus de chaque propriété :

  Champ obligatoire       → #[Assert\NotBlank]
  Champ date obligatoire  → #[Assert\NotNull]
  Longueur max            → #[Assert\Length(max: 255)]
  Date de fin > début     → #[Assert\GreaterThanOrEqual(propertyPath: 'dateDebut')]

  Exemple :
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $fullName = null;


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 3 — Mettre à jour la base de données
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  php bin/console make:migration
  php bin/console doctrine:migrations:migrate


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 4 — Créer les fixtures (données de test)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  php bin/console make:fixtures NomEntiteFixtures

  → Écrire les données de test dans le fichier généré
  → Si besoin d'une entité liée : getDependencies() + getReference()

  Exemple :
    $absence = new Absence();
    $absence->setFullName('Jean Dupont');
    $absence->setCourse($this->getReference('course_1', Course::class));
    $manager->persist($absence);

  php bin/console doctrine:fixtures:load --append


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 5 — Créer le formulaire + controller + vues
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  php bin/console make:crud NomEntite

  → Génère : Form/ + Controller/ + templates/
  → Supprimer les routes inutiles (edit, show, index si pas demandé)
  → Modifier le FormType :
       Dates      → 'widget' => 'single_text'
       Facultatif → 'required' => false
       Supprimer les champs gérés par le controller (relation parente)

  Exemple FormType :
    ->add('fullName', TextType::class, ['required' => true])
    ->add('reason',   TextType::class, ['required' => false])
    // NE PAS ajouter le champ course → géré dans le controller


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 6 — Logique métier dans le controller
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  → Dans la route new() après isSubmitted() && isValid()
  → Vérifier la règle avant persist()
  → Si violation → addFlash('error', '...') + redirect

  Exemple doublon :
    $existe = $repo->findOneBy(['fullName' => $absence->getFullName(), 'course' => $course]);
    if ($existe) {
        $this->addFlash('error', 'Cet étudiant est déjà absent pour cette intervention.');
        return $this->redirectToRoute('app_absence_new', ['id' => $course->getId()]);
    }

  Exemple chevauchement dates → faire dans make:validator (voir étape 6b)


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 6b — Validator (si règle métier complexe)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  php bin/console make:validator NomValidator

  → Fichier 1 NomValidator.php : message d'erreur + CLASS_CONSTRAINT
  → Fichier 2 NomValidatorValidator.php : logique + appel repository
  → Appliquer sur l'entité : #[NomValidator] au-dessus de "class MonEntite"

  Exemple NomValidator.php :
    public string $message = "L'enseignant {{ name }} est indisponible à ces dates.";
    public function getTargets(): string { return self::CLASS_CONSTRAINT; }

  Exemple NomValidatorValidator.php :
    if ($this->repo->hasOverlap($instructor->getId(), $start, $end)) {
        $this->context->buildViolation($constraint->message)->atPath('endDate')->addViolation();
    }


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 7 — Modifier les templates Twig
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  → Ajouter un tableau sur la fiche existante (show.html.twig)
  → Bouton "Ajouter" → route new
  → Tableau qui liste les entrées
  → Bouton "Supprimer" → form POST vers route delete

  Exemple :
    {% for absence in course.absences %}
        <tr><td>{{ absence.fullName }}</td><td>{{ absence.reason ?? '—' }}</td></tr>
    {% else %}
        <tr><td colspan="3">Aucune absence.</td></tr>
    {% endfor %}


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ÉTAPE 8 — Tester
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

  → Tester l'ajout, la suppression, la validation
  → Tester que la règle métier bloque bien le cas interdit
  → En cas de bug :
       php bin/console cache:clear
       php bin/console debug:router


══════════════════════════════════════════════════════════
  RAPPEL COMMANDES RAPIDES
══════════════════════════════════════════════════════════

  make:entity        → entité + repository
  make:migration     → générer la migration
  migrate            → appliquer en base
  make:crud          → form + controller + vues d'un coup
  make:validator     → validator personnalisé
  make:fixtures      → fixtures
  fixtures:load      → charger en base (--append = sans vider)
  cache:clear        → vider le cache
  debug:router       → voir toutes les routes
