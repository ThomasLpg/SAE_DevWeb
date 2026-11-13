<?php 

namespace iutnc\iks\action;
use iutnc\iks\repo;

class SeDesabonnerUtilisateurAction extends Action {
    
    public function execute() : string {
        if(empty($_SESSION['utilisateur'])){
            return "<p>Vous devez vous <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
        }
        try {
            // On récupère dans l'url le mail
            if (!isset($_SESSION['utilisateur'])){
                header('Location: index.php');
                return "";
            }

            $repoUnfollow = repo\SuivreRepository::getInstance();
            $repoUser= repo\UtilisateurRepository::getInstance();
            $pseudo = $_GET["suivi"];           

            // On insère dans la table Suivre le couple (mail actuel, mail suivi)
            $repoUnfollow->nePlusSuivreUtilisateur($pseudo);

            return "<p>Vous ne suivez plus <a href='?action=rechercher&info-a-rechercher={$pseudo}'>{$pseudo}</a></p>"
                   . "<br>"
                   . "<a href='?action=suivre-utilisateur&suivi={$pseudo}'>Suivre</a><br>"
                   . "<a class=accueil href='?action=afficher-post'>🏠Accueil</a>";
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }
}