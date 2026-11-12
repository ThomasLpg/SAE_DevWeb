<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\ListePostsRepository;

class AfficherMurUtilisateur extends Action{
    function execute(): string {
        if(empty($_SESSION['utilisateur'])){
            return "<p>Veuillez vous <a href=\"?action=authentifier\">connecter</a> pour accéder à votre fil Pour Toi.</p>";
        }
        $user = $_SESSION['utilisateur'];
            $mail = $user->__get('mail');
            
            try {
                $repo = ListePostsRepository::getInstance();
                $suivis = $repo->listePostsPourtoi($mail);

                $html = "<h3 class='titre-page'>Pour toi</h3>"
                        ."<a href='?action=afficher-post' class='bouton-accueil'>Accueil</a>" ;
                if(empty($suivis->getListe())){
                    $html .= '<p>Rien à voir par ici...</p>'
                          . "<a href='?action=afficher-post'>Accueil</a>";
                }
                else{
                    $html .= $suivis->afficherPostsCourt() ;
                }
                return $html;

            }catch(\Exception $e){
                return '<p>Erreur : ' . $e->getMessage() . '</p>';
            }

            return "<p>erreur 404</p>";
        }
}