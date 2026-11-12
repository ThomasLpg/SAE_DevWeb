<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\ListePostsRepository;
use iutnc\iks\appli\Pagination;
use iutnc\iks\appli\ListePosts;

class RechercherAction extends Action{
    function execute(): string {

        $recherche = trim($_GET['info-a-rechercher'] ?? $_POST['info-a-rechercher'] ?? '');

        if(!empty($recherche)){
            try{
                $repo = ListePostsRepository::getInstance();
            
                if(str_starts_with($recherche, '#')){

                    $recherche = ltrim($recherche, '#');
                    $liste = $repo->listePostTag($recherche);
                }else{
                    $liste = $repo->listePostUtilisateur($recherche);
                    
                    $pagination = Pagination::initierPage($liste->getListe());

                    $tab_a_afficher= $pagination->getEltsPage();
                    $liste_a_afficher = new ListePosts($tab_a_afficher);
                    
                    $html = $liste_a_afficher->afficherPostsCourt();

                    $html .= $pagination->afficherPagination("rechercher&info-a-rechercher=$recherche");

                }
            

                if(empty($liste->getListe())){
                    "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
                }else{
                    return "<a href='?action=afficher-post'>Accueil</a>" . $html;
                }   
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        return "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
    }

}