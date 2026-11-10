<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\ListePostsRepository;

class DefaultAction extends Action{
    function execute() : string{
        $affichage = "";
        $affichage .= <<<FIN
            <a href=?action=afficher-liste-Iks role="button">Liste d'Iks</a>
            <a href=?action=publier-post role="button">Ajouter un poste</a>
        FIN;

        
        $affichage .= $this->renderBarreRecherche();

       
        $recherche = trim($_POST['info-a-rechercher'] ?? '');

        if(!empty($recherche)){
            try{
                    $repo = ListePostsRepository::getInstance();
            
                if(str_starts_with($recherche, '#')){
                    $liste = $repo->listePostTag($recherche);
                }else{
                    $liste = $repo->listePosts($recherche);
                }
            

                if(empty($liste->getListe())){
                    $affichage .= "<p>Recherche introuvable</p>";
                }else{
                    return $affichage .= $liste->afficherPostsCourt();
                }   
            }catch(\Exception $e){
                return $e->getMessage();
            }
        }
        return $affichage;
        
    }


    function renderBarreRecherche() : string{
        $valeur = trim($_POST['info-a-rechercher'] ?? '');
        return <<<HTML
            <form id="f1" method="POST"
                action="index.php?action=default">

                <input type="text" name="info-a-rechercher" placeholder="Rechercher par email ou par tag" value="{$valeur}" required>

                <button type="submit" name="rechercher" 
                value="validation-form-auth">Rechercher</button>
            </form>
            HTML;
    }
}