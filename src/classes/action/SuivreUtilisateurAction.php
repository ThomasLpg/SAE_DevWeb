<?php 

namespace iutnc\iks\action;
use iutnc\iks\repo;

class SuivreUtilisateurAction extends Action {
    
    public function execute() : string {
        try {
            // On récupère dans l'url le mail
            if (!isset($_SESSION['utilisateur'])){
                header('Location: index.php');
                return "";
            }

            $repoSuivre = repo\SuivreRepository::getInstance();
            $repoUser= repo\UtilisateurRepository::getInstance();
            $pseudo = $_GET["suivi"];           

            // On insère dans la table Suivre le couple (mail actuel, mail suivi)
            $repoSuivre->suivreUtilisateur($pseudo);

            return "<p>Vous suivez maintenant {$pseudo}</p>"
                   . "<br>"
                   . "<a href='?action=afficher-post'>Accueil</a>";
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }
}