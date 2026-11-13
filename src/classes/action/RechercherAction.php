<?php

namespace iutnc\iks\action;
use iutnc\iks\repo as repo;
use iutnc\iks\appli\Pagination;
use iutnc\iks\appli\ListePosts;

class RechercherAction extends Action{
    function execute(): string {
        if(empty($_SESSION['utilisateur'])){
            return "<p>Vous devez vous <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
        }

        $recherche = filter_var(trim($_GET['info-a-rechercher'] ?? $_POST['info-a-rechercher'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);

        if(!empty($recherche)){
            try{
                $repo = repo\ListePostsRepository::getInstance();
            
                if(str_starts_with($recherche, '#')){
                    $recherche = ltrim($recherche, '#');
                    $liste = $repo->listePostTag($recherche);
                    if(empty($liste->getListe())){
                        return "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
                    }else{
                        try{
                            $repoTag = repo\TagRepository::getInstance();
                            $mailUser = $_SESSION['utilisateur']->__get('mail');
                            if(!($repoTag->estAbonne($mailUser, $recherche))){
                                return "<a href='?action=afficher-post'>Accueil</a> <a href='?action=suivre-tag&info-a-rechercher=$recherche'> Suivre le tag #{$recherche} ? </a>" . ($html ?? $liste->afficherPostsCourt());

                            } else{
                                return "<a href='?action=afficher-post'>Accueil</a> <a href='?action=ne-plus-suivre-tag&info-a-rechercher=$recherche'> Ne plus suivre le tag #{$recherche}  </a>" . ($html ?? $liste->afficherPostsCourt());
                            }
                        } catch (\Exception $e){
                            return "<p>Une erreur s'est produite : " . $e->getMessage . " <a href='?action=afficher-post'>Accueil</a>";
                        }
                    } 

                    } else {
                        $liste = $repo->listePostUtilisateur($recherche);
                        
                        $pagination = Pagination::initierPage($liste->getListe());

                        $tab_a_afficher= $pagination->getEltsPage();
                        $liste_a_afficher = new ListePosts($tab_a_afficher);
                        
                        $html = $liste_a_afficher->afficherPostsCourt();

                        $html .= $pagination->afficherPagination("rechercher&info-a-rechercher=$recherche");
                        $html .= "<br><a href='?action=afficher-post'>Accueil</a>";
                        
                    }
                

                  
            }catch(\Exception $e){
                return $e->getMessage();
            }
            return ($html ?? $liste->afficherPostsCourt());

        }
        return "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
    }

}