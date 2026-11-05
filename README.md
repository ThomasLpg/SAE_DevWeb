# SAE_DevWeb

Equipe :
    MATHIOT Théo
    ROHR Valentin
    DEFLOU-CARON Maxime
    LEPAGE Thomas

Pour utiliser l'application : vous devrer vous devrez avoir docker
Vous devez avoir dans le .env de docker cette config : 
DB_ROOT_PASSWORD=root
DB_USER=s3
DB_USER_PASSWORD=s3
DB_NAME=s3

A la racine de ce projet ajouter le fichier suivant : config.ini
avec cette configuration : 
driver=mysql
username=s3
password=s3
host=mysql
database=s3

Importer le fichier mysqlRequetes.sql dans votre bd mariaDb (y acceder à partir de docker)

Vous devrez cloner le projet git dans le dossier code de docker
Ensuite lancer docker et vous rendre sur la page localhost:8000/index.php
Ou localhost:8000/VOSSOUSDOSSIERS/index.php



