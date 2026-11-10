<?php

namespace iutnc\iks\action;

class DefaultAction extends Action{
    function execute() : string{
        $affichage = "";
        $affichage .= <<<FIN
            <a href=?action=afficher-liste-Iks role="button">Liste d'Iks</a>
            <a href=?action=publier-post role="button">Ajouter un poste</a>
        FIN;

        $affichage .= $this->renderBarreRecherche();

        $tag = "";

        $liste = "";

        $repo = ListePostsRepository::getInstance();

        $recherche = trim($_GET['info-a-rechercher'] ?? '');

        try{
            if(!empty($recherche)){
                if(str_starts_with($recherche, '#')){
                    $tag = $recherche;
                    $liste = $repo->listePostsTag($tag);
                }else{
                    $liste = $repo->listePostsUtilisateur($recherche)
                }
            }

            if(empty($liste->getListe())){
                $affichage .= "<p>Recherche introuvable</p>"
            }else{
                
            }
                
        }
        
    }


    function renderBarreRecherche() : string{
        return <<<HTML
            <form id="f1" method="post"
                action="index.php?action=defaut">

                <input type="text" name="info-a-rechercher" placeholder="Barre de recherche" required>

                <button type="submit" name="rechercher" 
                value="validation-form-auth">Rechercher</button>
            </form>
            HTML;
    }
}