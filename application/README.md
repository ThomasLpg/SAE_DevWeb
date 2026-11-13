# SAE_DevWeb

Equipe :
    MATHIOT Théo
    ROHR Valentin
    DEFLOU-CARON Maxime
    LEPAGE Thomas

Notre application s'appelle 'IKS' (prononcer X).

Pour utiliser l'application (coté utilisateur) : vous devrez avoir Docker

Il faut ensuite ajouter un fichier : conf.ini à la racine de /application

Vous devez avoir les données du .env de docker relié à votre .ini de l'appli: avec ces informations à l'intérieur (à relié au .env et au nom de la bd que vous allez créer):




conf.ini :
driver=mysql
username=à compléter : .env docker
password=à compléter : .env docker
host=mysql
database=nom de la bd dans phpMyAdmin

=

.env :
DB_ROOT_PASSWORD=
DB_USER=
DB_USER_PASSWORD=
DB_NAME=
DB_ROOT=


Importer le fichier mysqlRequetes.sql et Triggers.sql dans votre bd (même nom que pour  phpMyAdmin (y accéder à partir de docker)

Vous devrez cloner le projet git dans le dossier code de docker

Ensuite lancer docker et vous rendre sur la page suivante pour le coté utilisateur : localhost:8000/SAE_devweb/application/index.php


Ensuite pour utiliser l'application, créer simplement un compte avec un email valide 
(nom@domaine.extentiondomaine), ensuite un nom, un prénom et un pseudo (le nom de l'utilisateur).

Pour pouvoir tester les fonctionnalités, on vous conseil publier des postes à partir
d'un premiers comptes et de revenir sur l'url de départ pour en créer un 
autre (afin de tester liker, suivre, suivreTag…). (Nous n'avons pas eu le temps de développer une fonction pour se déconnecter)

Pour l’application côté administrateur, se rendre dans localhost:8000/SAE_devweb/back-office/index.php


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



PS : Thomas a créer le repository avec un compte GitHub et codé avec un pc qui avait une clé SSH différente de son compte
donc son nom apparaît deux fois dans les commits -> ThomasLpg n'a servi qu'au commit initial.


