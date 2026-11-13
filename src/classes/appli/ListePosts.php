<?php

namespace iutnc\iks\appli;

use iutnc\iks\repo\UtilisateurRepository;
use iutnc\iks\repo\SuivreRepository;
use iutnc\iks\repo\LikerRepository;

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
            $mailUser = $user->__get('mail');
            $users_suivis = $repoSuivre->getSuivisUser($mailUser);

            $repoLiker = LikerRepository::getInstance();
            $posts_likes = $repoLiker->getSuiviLike($mailUser);


        } catch (\Exception $e){
            return $e->getMessage();
        }
       
        // A chaque poste qu'on veut afficher, on vérifie si l'auteur du post est suivi par l'utilisateur actuel
        // Si oui : alors on ajoute un bouton ne plus suivre qui permet de d'arreter suivre l'utilisateur 
        // Si non : alors on ajoute un bouton suivre qui permet de suivre l'utilisateur
        

        foreach($this->liste as $p){
            $boutonSuivi = "";
            $court = $p->renderCourt();
            $long = $p->render();
            $user = $p->__get('auteur');
            $pseudo = $user->__get('pseudo');
            $date = $p->__get('datePub');
            $mail= $user->__get('mail');
            $idPost = $p->__get('numPost');
            $nbLikes = $p->__get('nblikes');
            

            //Si le mail n'est pas dans la liste de nos Utilisateur suivi
            //ET que le le pseudo est différent du notre
            if($pseudo !== $_SESSION['utilisateur']->__get('pseudo')){

                if (!in_array($mail, $users_suivis, true)) {
                    //Alors on peut le suivre
                    $boutonSuivi = "<a href='?action=suivre-utilisateur&suivi={$pseudo}'>Suivre</a>";
                    
                //Sinon si il y est que le pseudo est différent du notre 
                }else{
                    //On a la possibilité de s'y désabonner
                    $boutonSuivi = "<a href='?action=ne-plus-suivre-utilisateur&suivi={$pseudo}'>Ne plus suivre</a>";
                }
            }

            $estLike = in_array($idPost, $posts_likes, true);
            $boutonLike = "";
            if($estLike){
                $boutonLike = "<a href='?action=ne-plus-liker&id-post=$idPost'>{$nbLikes}</a>";
                //Like du post -1
            } else{
                 $boutonLike = "<a href='?action=liker&id-post=$idPost'>{$nbLikes}</a>";
                 //Like du post +1
            }



            $res .= "
            <a href='?action=rechercher&info-a-rechercher={$pseudo}' class=\"auteur-iks\">{$pseudo}</a>
            {$boutonSuivi}
            <details>
                <summary class=\"post-affichage\"> 
                    <span class=\"version-courte\">{$court}</span>
                    <span class=\"version-longue\">{$long}</span>
                </summary>
            
            </details>
            <div class=\"like-iks\">{$boutonLike}</div>
            <div class=\"date-iks\">{$date}</div>
            <br>";
        }

        return "<div class=\"liste-de-posts\">{$res}</div>";
    }
}