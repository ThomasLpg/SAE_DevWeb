# SAE_DevWeb

Equipe :
    MATHIOT Théo
    ROHR Valentin
    DEFLOU-CARON Maxime
    LEPAGE Thomas

Pour utiliser l'application : vous devrer vous devrez avoir docker
Vous devez avoir dans le .env de docker relié a votre .ini de l'appli 

Importer le fichier mysqlRequetes.sql et Triggers.sql dans votre bd mariaDb (y acceder à partir de docker)

Vous devrez cloner le projet git dans le dossier code de docker
Ensuite lancer docker et vous rendre sur la page localhost:8000/index.php
Ou localhost:8000/application/SAE_devweb/index.php

ou Ou localhost:8000/back-office/SAE_devweb/index.php

1. FONCTIONNALITES UTILISATEURS

1. Afficher la liste des touites 

   Statut : Fait | Realise par : Thomas 



2. Afficher un touite en detail 
   Statut : Fait | Realise par : Thomas



3. Paginer la liste des touites

   Statut : Fait | Realise par : Maxime



4. Afficher les touites d'une personne donnee

   Statut : Fait | Realise par : Theo, Thomas



5. Afficher les touites associes a un tag (clic sur un tag)

   Statut : Fait | Realise par : Theo



6. Publier un touite

   Statut : Fait | Realise par : Theo, Thomas, Maxime



7. Evaluer un touite (like / dislike)

   Statut : Fait | Realise par : Thomas



8. Gerer les tags

   Statut : Fait | Realise par : Theo



9. Afficher le mur d'un utilisateur 

   Statut : Fait | Realise par : Thomas, Valentin



10. Suivre des utilisateurs 

    Statut : Fait | Realise par : Maxime



11. S'abonner a un tag (saisie directe depuis le mur)

    Statut : Reserve / En cours | Realise par : Thomas, Théo



12. Afficher les abonnes d'un utilisateur (liste des followers + score moyen)

    Statut : Fait | Realise par : Maxime



13. Associer une image a un touite (upload serveur, affichage en vue detaillee uniquement)

    Statut : Fait | Realise par : Maxime



2. FONCTIONNALITES ADMINISTRATEURS (BACK-OFFICE)

14. Afficher les influenceurs (utilisateurs classes par nombre de suiveurs)

    Statut : Fait | Realise par : Maxime



15. Afficher les tendances (tags les plus mentionnes avec occurrences)

    Statut : Fait | Realise par : Maxime



16. Developper un back-office (application independante regroupant influenceurs et tendances)

    Statut : Fait | Realise par : Maxime





3. ARCHITECTURE & CLASSES TECHNIQUES (src/classes/)


Modeles (appli/) :

- Tag.php : Valentin

- Image.php : Theo

- AbonnerTag.php : Theo

- Utilisateur.php : Theo

- Suivre.php : Theo

- ContenuTag.php : Theo

- Post.php : Thomas

- ListePosts.php : Thomas

- Pagination : Maxime



Actions, Dispatch & Repositories (action/, dispatch/, repo/) :

- Dispatcher (Dispatcher.php) : Thomas

- Repositories (IksRepository.php, UtilisateurRepository) : Theo, Thomas

- Actions de base (Action.php, DefaultAction.php, AuthentificationAction.php) : Thomas

- Actions complementaires (AssocierTag, SuivreAction, AbonnerUnTagAction, NoterAction, AfficherPostsAuteurAction) : Thomas





4. AMELIORATIONS 



- Recherche par pseudo (remplacement de la recherche par mail) : Maxime

- Correction du bouton Suivre / Ne plus suivre (bug de disparition apres 3 clics) : Maxime

- Masquage du bouton de suivi de tag lors de la consultation d'un profil utilisateur : Maxime

- Affichage du terme recherche (tag ou pseudo affiche au-dessus des resultats) : Theo (reserve)

- Redirection post-follow et CSS : Thomas



