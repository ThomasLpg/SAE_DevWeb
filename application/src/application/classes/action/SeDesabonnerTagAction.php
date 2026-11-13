<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\TagRepository;

class SeDesabonnerTagAction extends Action{
    function execute(): string{
        if(empty($_SESSION['utilisateur'])){
            return "<p>Vous devez vous <a href='index.php?action=authentifier'>connecter</a> pour continuer</p>";
        }
        
        $user = $_SESSION['utilisateur'];
        $mailUser = $user->__get('mail');
        
        $libelle = $_GET['info-a-rechercher'];

        if(empty($libelle)){
            return "<p>Aucun Tag donné</p> <a class=accueil href='?action=afficher-post'>🏠Accueil</a>";
        }
        
        try{
            $repo = TagRepository::getInstance();
            $verif = $repo->estAbonne($mailUser, $libelle);

            if($verif){
                $idTag = $repo->trouverTag($libelle);
                $repo->seDesabonnerTag($idTag);
            }else{
                if(!$verif){
                    return "<p>Vous n'êtes pas abonné au tag : ". $libelle . "</p> <a class=accueil href='?action=afficher-post'>🏠Accueil</a>";
                }
            }

        header("Location: index.php?action=rechercher&info-a-rechercher=" . urlencode("#" . $libelle));

        }catch(\Exception $e){
            return "<p>{$e->getMessage()}</p>";
        }
        return "<p>Erreur 404</p>";
    }
}