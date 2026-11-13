<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\LikerRepository;

class UnLikerAction extends Action{
    function execute(): string{
        if(empty($_SESSION['utilisateur'])){
            return "<p>Vous devez vous <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
        }

        if(empty($_GET['id-post'])){
            return "<p>Aucun post à liker ici</p> <a class=accueil href='?action=afficher-post'>🏠Accueil</a>";
        }
        $user = $_SESSION['utilisateur'];
        $mailUser = $user->__get('mail');

        $idTag = $_GET['id-post'];

        try{
            $repo = LikerRepository::getInstance();
            $repo->unLiker($mailUser, $idTag);
            
            $urlRetour = $_SERVER['HTTP_REFERER'] ?? 'index.php?action=afficher-post';
            header("Location: " . $urlRetour);
            exit;

        } catch(\Exception $e){
            return "<p>{$e->getMessage()}</p>";
        }
        return "";
    }
}