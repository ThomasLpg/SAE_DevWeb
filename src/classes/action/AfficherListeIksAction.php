<?php

namespace iutnc\iks\action;

use iutnc\iks\appli\ListePosts;
use iutnc\iks\repo\ListePostsRepository;

class AfficherListeIksAction extends Action{
    function execute() : string{
        $listePosts = null;
        if($_SERVER['REQUEST_METHOD'] == "GET"){

            try{
                $repo = ListePostsRepository::getInstance();
                $listePosts = $repo->listePosts();

            }catch(\Exception $e){
                return $e->getMessage();
            }

            return $this->afficherPostsCourt($listePosts);

        }
        return $this->renderFormulaire();
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

    function afficherPostsCourt(ListePosts $liste): string{
        $listePosts = $liste->getListe();

        $res = "";

        foreach($listePosts as $p){
            $res .= $p->renderCourt();
        }

        return "<p>{$res}</p>";
    }
}