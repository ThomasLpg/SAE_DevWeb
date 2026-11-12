<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\ListePostsRepository;

class RechercherAction extends Action{
    function execute(): string {

        $recherche = trim($_GET['info-a-rechercher'] ?? $_POST['info-a-rechercher'] ?? '');

        if(!empty($recherche)){
            try{
                $repo = ListePostsRepository::getInstance();
            
                if(str_starts_with($recherche, '#')){
                    $liste = $repo->listePostTag($recherche);
                }else{
                    $liste = $repo->listePostUtilisateur($recherche);
                }
            

                if(empty($liste->getListe())){
                    "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
                }else{
                    return "<a href='?action=afficher-post'>Accueil</a>" . $liste->afficherPostsCourt();
                }   
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        return "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
    }
    
}