<?php

namespace iutnc\iks\action;

use iutnc\iks\appli\ListePosts;

class AfficherListeIksAction extends Action{
    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $listePosts = null;

            try{
                $repo = ListePostsRepository::getInstance();
                $listePosts = $repo->listePosts();

            }catch(Exception $e){
                return $e->getMessage();
            }

            return $this->afficherPostsCourt();

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

    function afficherPostsCourt(ListePosts $liste){
        $listePosts = $liste.getListe();

        $res = "";

        foreach($listePosts){

        }

        return res;
    }
}