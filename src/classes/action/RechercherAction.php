<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\ListePostsRepository;
use iutnc\iks\repo\TagRepository;

class RechercherAction extends Action{
    function execute(): string {
        if(empty($_SESSION['utilisateur'])){
            return "<p>Vous devez vous <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
        }
        $recherche = trim($_GET['info-a-rechercher'] ?? $_POST['info-a-rechercher'] ?? '');

        if(!empty($recherche)){
            try{
                $repo = ListePostsRepository::getInstance();
            
                if(str_starts_with($recherche, '#')){
                    $recherche = ltrim($recherche, '#');
                    $liste = $repo->listePostTag($recherche);

                }else{
                    $liste = $repo->listePostUtilisateur($recherche);
                }
            

                if(empty($liste->getListe())){
                    "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
                }else{
                    try{
                        $repoTag = TagRepository::getInstance();
                        $mailUser = $_SESSION['utilisateur']->__get('mail');
                        if(!($repoTag->estAbonne($mailUser, $recherche))){
                            return "<a href='?action=afficher-post'>Accueil</a> <a href='?action=suivre-tag&info-a-rechercher=$recherche'> Suivre ce tag ? </a>" . $liste->afficherPostsCourt();

                        } else{
                            return "<a href='?action=afficher-post'>Accueil</a> <a href='?action=ne-plus-suivre-tag&info-a-rechercher=$recherche'> Ne plus suivre ce tag </a>" . $liste->afficherPostsCourt();
                        }
                    } catch (\Exception $e){
                        return "<p>Une erreur s'est produite : " . $e->getMessage . " <a href='?action=afficher-post'>Accueil</a>";
                    }
                }   
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        return "<a href='?action=afficher-post'>Accueil</a> <p>Aucun tag ou utilisateur trouvé...</p>";
    }

}