<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\TagRepository;

class AbonnerTagAction extends Action{
    function execute(): string{
        if(empty($_SESSION['utilisateur'])){
            return "<p>Vous devez vous <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
        }

        $user = $_SESSION['utilisateur'];
        $mailUser = $user->__get('mail');

        $idTag = $_GET['tag-a-sabonner'];

        try{
            $repo = TagRepository::getInstance();
            if($repo->sabonnerTag($mailUser, $idTag));

        }catch(\Exception $e){
            return '<p>{$e->getMessage()}</p>';
        }
    }
}