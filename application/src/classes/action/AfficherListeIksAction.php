<?php

namespace iutnc\iks\action;

use iutnc\iks\repo\ListePostsRepository;
use iutnc\iks\appli\Pagination;
use iutnc\iks\appli\ListePosts;
use iutnc\iks\action\RechercherAction;

class AfficherListeIksAction extends Action{
    function execute() : string{
        $listePosts = null;
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            if (empty($_SESSION['utilisateur'])) {
                return "<p>Vous devez vous  <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
            }
            try{
                $repo = ListePostsRepository::getInstance();
                $listePosts = $repo->listePosts();

                // On récupère le tableau de tous les posts
                $tabPosts = $listePosts->getListe();
                if (empty($tabPosts)){
                    return "<div class=accueil-menu><a class=publier-un-post href='?action=publier-post'>Publier</a><a class=Mur href='?action=pourtoi'>Votre Mur</a></div>" . $this->renderBarreRecherche() . "<p>Aucun post...</p>";
                }
                // On doit ensuite construire les pages à partir de ce tableau et en fonction du nombre de posts par page choisi
                $pagination = Pagination::initierPage($tabPosts);

                $affichage = $pagination->getEltsPage();
                
                $res = $this->afficherPostsCourt($affichage);

                $res .= $pagination->afficherPagination("afficher-post");

                return "<div class=accueil-menu><a class=publier-un-post href='?action=publier-post'>Publier</a><a class=Mur href='?action=pourtoi'>Votre Mur</a>"
                        . $this->renderBarreRecherche() . "</div>"
                        . $res;
    
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        return "En cours de traitement, restez à l'écoute de nouvelles mises à jour !";
    }

    function renderBarreRecherche() : string{
        $valeur = trim($_POST['info-a-rechercher'] ?? '');
        return <<<HTML
            <form id="f1" method="POST"
                action="index.php?action=rechercher">
    
                <input type="text" name="info-a-rechercher" placeholder="Rechercher un pseudo ou tag" value="{$valeur}" required>

                <button type="submit" name="rechercher" 
                value="validation-form-auth">Rechercher</button>
            </form>
            HTML;
    }

    function afficherPostsCourt(array $listePosts): string{     
        $lst = new ListePosts($listePosts);           
        $res = $lst->afficherPostsCourt();
        $res .= "<a href = ?action=afficher-abos>Abonnés</a>";
        return $res;
    }

   
}