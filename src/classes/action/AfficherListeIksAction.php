<?php

namespace iutnc\iks\action;

use iutnc\iks\appli\ListePosts;
use iutnc\iks\repo\ListePostsRepository;
use iutnc\iks\appli\Page;
use iutnc\iks\appli\ListePage;

class AfficherListeIksAction extends Action{

    function execute() : string{
        $listePosts = null;
        if($_SERVER['REQUEST_METHOD'] == "GET"){

            try{
                $repo = ListePostsRepository::getInstance();
                $listePosts = $repo->listePosts();

                // On récupère le tableau de tous les posts
                $tabPosts = $listePosts->getListe();
                // On doit ensuite construire les pages à partir de ce tableau et en fonction du nombre de posts par page choisi
                $listePages = new ListePage();
                // Initialisation de la première page 
                $nbPostsParPage = $_GET['nbPostsParPage'];
                $numpage = 1;
                $page = new Page($nbPostsParPage);

                foreach($tabPosts as $post){
                    $ret = $page->ajouterPost($post);
                    if ($ret === 0){
                        $listePages->ajouterPage($page);
                        $page = new Page($nbPostsParPage);
                        $numpage++;
                        $page->ajouterPost($post);
                    }
                }
                $listePages->ajouterPage($page);
                $tabPages = $listePages->getListe();
                $nbPages = $tabPages.size();

                if ($nbPages === 0) {
                    return "<p>Aucun post</p>";
                }
                
                if (isset($_GET['page'])){
                    $numPageActuelle = (int) $_GET['page'];
                    if ($numPageActuelle > $nbPages){
                        $numPageActuelle = 1;
                    }
                } else {
                    $numPageActuelle = 1;
                }

                $pageActuelle = $listePages->getPage($numPageActuelle);


        

                return $this->afficherPostsCourt($listePosts);

            }catch(\Exception $e){
                return $e->getMessage();
            }
        }

        if (($numPageActuelle - 1) >= 1) 
            $numPagePrec = $numPageActuelle - 1;
        if (($numPageActuelle + 1) <= $nbPages){
            $numPageSuiv = $numPageActuelle + 1;
        }
        return '<a href="?action=afficher-liste-Iks&page=$numPagePrec&nbPostsParPage=3">Page précédente</a>' . $this->renderFormulaire()
        . '<a href="?action=afficher-liste-Iks&page=$numPageSuiv&nbPostsParPage=3">Page suivante</a>';
    }



    function renderFormulaire() : string{
        return <<<HTML
        <a href=?action=default role="button">Accueil</a>
        <br>
        <p>BD liste de Iks en cours...</p> 
        <h3>Liste d'IKS : </h3>
        <select name = "liste-Iks">
            afficherPostsCourt();
        </select>
        
        HTML;
    }

    function afficherPostsCourt(Page $page): string{
        $listePosts = $page->__get('listePost');
        $res = "";

        foreach($listePosts as $p){
            $res .= $p->renderCourt();
        }

        return "<p>{$res}</p>";
    }

   
}