<?php

namespace iutnc\iks\appli;

use iutnc\iks\repo\UtilisateurRepository;
use iutnc\iks\repo\SuivreRepository;

class ListePosts{

    function __construct(private array $liste = []){}

    function ajouterPost(Post $post): void{
        $this->liste[] = $post;
    }

    function supprimerPost(Post $post): void{
        foreach($this->liste as $index => $actuelPost){
            if($actuelPost == $post){
                unset($this->liste[$index]);
                break;
            }
        }
    }

    function getPost(int $n): Post{
        return $this->liste[$n];
    }

    function getListe() : array{
        return $this->liste;
    }

    function afficherPostsCourt(): string{     
        $res = "";
        try {
            $repoSuivre = SuivreRepository::getInstance();
            // On récupère la liste des utilisateurs suivis par l'utilisateur actuel
            $user = $_SESSION['utilisateur'];
            $users_suivis = $repoSuivre->getSuivisUser($user->__get('mail'));
        } catch (\Exception $e){
            return $e->getMessage();
        }
       
        // A chaque poste qu'on veut afficher, on vérifie si l'auteur du post est suivi par l'utilisateur actuel
        // Si oui : alors rien ne se passe, on affiche le poste normalement
        // Si non : alors on ajoute un bouton suivre qui permet de suivre l'utilisateur
        

        foreach($this->liste as $p){
            $suivre = "";
            $unfollow = "";
            $court = $p->renderCourt();
            $long = $p->render();
            $user = $p->__get('auteur');
            $pseudo = $user->__get('pseudo');
            $date = $p->__get('datePub');
            $mail= $user->__get('mail');

            //Si le mail n'est pas dans la liste de nos Utilisateur suivi
            //ET que le le pseudo est différent du notre
            if (!in_array($mail, $users_suivis, true) && ($pseudo !== $_SESSION['utilisateur']->__get('pseudo'))) {
                //Alors on peut le suivre
                $suivre = "<a href='?action=suivre-utilisateur&suivi={$pseudo}'>Suivre</a>";
            //Sinon si il y est que le pseudo est différent du notre 
            }else if ($pseudo !== $_SESSION['utilisateur']->__get('pseudo')){
                //On a la possibilité de s'y désabonner
                $unfollow = "<a href='?action=ne-plus-suivre-utilisateur&suivi={$pseudo}'>Ne plus suivre</a>";
            }

            $res .= "
            <a href='?action=rechercher&info-a-rechercher={$mail}' class=\"auteur-iks\">{$pseudo}</a>
            {$unfollow}
            <details>
                <summary class=\"post-affichage\"> 
                    <span class=\"version-courte\">{$court}</span>
                    <span class=\"version-longue\">{$long}</span>
                </summary>
            
            </details>
            <h3>{$suivre}</h3>
            <div class=\"date-iks\">{$date}</div>
            <br>";
        }

        return "<div class=\"liste-de-posts\">{$res}</div>";
    }
}