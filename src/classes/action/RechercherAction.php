<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\ListePostsRepository;

class RechercherAction extends Action{
    function execute(): string {

        $recherche = trim($_POST['info-a-rechercher'] ?? '');

        if(!empty($recherche)){
            try{
                $repo = ListePostsRepository::getInstance();
            
                if(str_starts_with($recherche, '#')){
                    $liste = $repo->listePostTag($recherche);
                }else{
                    $liste = $repo->listePostUtilisateur($recherche);
                }
            

                if(empty($liste->getListe())){
                    "<p>Recherche introuvable</p>";
                }else{
                    return '<a href=\'?action=afficher-post\'>Retourner à l\'acceuil</a>' . $liste->afficherPostsCourt();
                }   
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        return 'Erreur 404';
    }
    
}