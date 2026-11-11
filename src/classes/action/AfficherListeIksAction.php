<?php

namespace iutnc\iks\action;

use iutnc\iks\repo\ListePostsRepository;
use iutnc\iks\appli\Page;
use iutnc\iks\appli\ListePage;
use iutnc\iks\action\RechercherAction;

class AfficherListeIksAction extends Action{

    function execute() : string{
        $listePosts = null;
        if($_SERVER['REQUEST_METHOD'] == "GET"){

            try{
                $repo = ListePostsRepository::getInstance();
                $listePosts = $repo->listePosts();

                // On récupère le tableau de tous les posts
                $tabPosts = $listePosts->getListe();
                if (empty($tabPosts)){
                    return $this->renderBarreRecherche() . "<p>Aucun post...</p>";
                }
                // On doit ensuite construire les pages à partir de ce tableau et en fonction du nombre de posts par page choisi
                $listePages = new ListePage();
                // Initialisation de la première page 
                if (isset($_GET['nbPostsParPage'])){
                    $nbPostsParPage = $_GET['nbPostsParPage'];
                } else {
                    $nbPostsParPage = 3;
                }
                
                $page = new Page($nbPostsParPage);

                foreach($tabPosts as $post){
                    $ret = $page->ajouterPost($post);
                    if ($ret === 0){
                        $listePages->ajouterPage($page);
                        $page = new Page($nbPostsParPage);
                        $page->ajouterPost($post);
                    }
                }
                $listePages->ajouterPage($page);
                $tabPages = $listePages->getListe();
                $nbPages = count($tabPages);
                
                if (isset($_GET['page'])){
                    $numPageActuelle = (int) $_GET['page'];
                    if (($numPageActuelle < 1)){
                        $numPageActuelle = 1;
                    } else if (($numPageActuelle > $nbPages)){
                        $numPageActuelle = $nbPages;
                    }
                } else {
                    $numPageActuelle = 1;
                }

                $pageActuelle = $listePages->getPage($numPageActuelle);


                $res = "";
                if (($numPageActuelle - 1) >= 1) {
                    $numPagePrec = $numPageActuelle - 1;
                    $res .= "<a href='?page=$numPagePrec&nbPostsParPage=3'>Page précédente</a><br>";
                }
                    
                if (($numPageActuelle + 1) <= $nbPages){
                    $numPageSuiv = $numPageActuelle + 1;
                    $res .= "<a href='?page=$numPageSuiv&nbPostsParPage=3'>Page suivante</a>";
                }


                return "<a href='?action=publier-post'>Publier un post</a>"
                        . $this->renderBarreRecherche()
                        . $this->afficherPostsCourt($pageActuelle)
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
    
                <input type="text" name="info-a-rechercher" placeholder="Rechercher par email ou par tag" value="{$valeur}" required>

                <button type="submit" name="rechercher" 
                value="validation-form-auth">Rechercher</button>
            </form>
            HTML;
    }

    function afficherPostsCourt(Page $page): string{
        $listePosts = $page->__get('listePosts');
                
        $res = $listePosts->afficherPostsCourt();
            
        return "<p>{$res}</p>";
    }

   
}