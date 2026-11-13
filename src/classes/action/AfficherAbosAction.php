<?php 

namespace iutnc\iks\action;

use iutnc\iks\repo as repo;

class AfficherAbosAction extends Action {
    
    public function execute() : string {
        if(empty($_SESSION['utilisateur'])){
            return "<p>Vous devez vous <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
        }
        try{
            // Récupérer les abonnés de l’utilisateur connecté 
            $repoSuiv = repo\SuivreRepository::getInstance();
            $repoUser = repo\UtilisateurRepository::getInstance();
            $repoPost = repo\PostRepository::getInstance();
            $res = "";
            $userMail = $_SESSION['utilisateur']->__get('mail');
            $listeUsers = $repoSuiv->getAbosUser($userMail);
            
            if (empty($listeUsers)){
                $res .= "Vous n'avez aucun abonné, faite vous connaitre !";
            }

            // Afficher avec une boucle les utilisateurs (utiliser getUtilisateur($email))
            foreach($listeUsers as $mailSuiver){
                $abo = $repoUser->getUtilisateur($mailSuiver);
                if($abo!=null){
                    $pseudo = $abo->__get('pseudo');
                    $res .= $pseudo . "<br>";
                }
            }
        
            // On ajoute au retour le nombre de likes moyen par post 
            $likes = $repoPost->getNbLikesMoyen($userMail);
            $res .= "<h2>Nombre de likes moyen : $likes</h2>";

        } catch (\Exception $e){
            $res = $e->getMessage();
        }
        return "<a class=accueil href='?action=afficher-post'>🏠Accueil</a><br>" . $res;
    }

}