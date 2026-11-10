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

            return "<a href=?action=publier-post role=\"button\">Ajouter un poste</a>" . 
            $listePosts->afficherPostsCourt();

        }
        return 'Erreur 404';
    }
}