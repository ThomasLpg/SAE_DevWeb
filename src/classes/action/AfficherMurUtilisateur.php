<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\ListePostsRepository;
use iutnc\iks\appli\ListePosts;
use iutnc\iks\appli\Pagination;


class AfficherMurUtilisateur extends Action{
    function execute(): string {
        if(empty($_SESSION['utilisateur'])){
            return "<p>Veuillez vous <a href=\"?action=authentifier\">connecter</a> pour accéder à votre mur.</p>";
        }
        $user = $_SESSION['utilisateur'];
            $mail = $user->__get('mail');
            
            try {
                $repo = ListePostsRepository::getInstance();
                $suivis = $repo->listePostsPourtoi($mail);

                $html = "<h3 class='titre-page'>Votre Mur : </h3>"
                        ."<a class=accueil href='?action=afficher-post'>🏠Accueil</a>" ;
                if(empty($suivis->getListe())){
                    $html .= '<p>Rien à voir par ici...</p>';
                } else {
                    
                    $pagination = Pagination::initierPage($suivis->getListe());

                    $tab_a_afficher= $pagination->getEltsPage();
                    $liste_a_afficher = new ListePosts($tab_a_afficher);
                    
                    
                    $html .= $liste_a_afficher->afficherPostsCourt();

                    $html .= $pagination->afficherPagination("pourtoi");
                
                }
                return $html;

            }catch(\Exception $e){
                return '<p>Erreur : ' . $e->getMessage() . '</p>';
            }

            return "<p>erreur 404</p>";
        }
}