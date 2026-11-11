<?php 

namespace iutnc\iks\action;

use iutnc\iks\repo as repo;

class AfficherAbosAction extends Action {
    
    public function execute() : string {
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
            foreach($listeUsers as $user){
                $tab = $repoUser->getUtilisateur($user);
                $res = $tab['pseudo'] . "<br>";
            }
        
            // On ajoute au retour le nombre de likes moyen par post 
            $likes = $repoPost->getNbLikesMoyen($userMail);
            $res .= "<h2>Nombre de likes moyen : $likes</h2>";

        } catch (\Exception $e){
            $res = $e->getMessage();
        }
        return $res . "<br><a href='?action=afficher-post'>Accueil</a>" ;
    }

}