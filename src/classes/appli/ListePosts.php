<?php

namespace iutnc\iks\appli;

use iutnc\iks\repo\UtilisateurRepository;

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

        foreach($this->liste as $p){
            $court = $p->renderCourt();
            $long = $p->render();
            $user = $p->__get('auteur');
            $pseudo = $user->__get('pseudo');
            $date = $p->__get('datePub');
            $mail= $user->__get('mail');

            $res .= "
            <a href='?action=rechercher&info-a-rechercher={$mail}' class=\"auteur-iks\">{$pseudo}</a>
            <details>
                <summary class=\"post-affichage\"> 
                    <span class=\"version-courte\">{$court}</span>
                    <span class=\"version-longue\">{$long}</span>
                </summary>
            
            </details>
            <div class=\"date-iks\">{$date}</div>
            <br>";
        }

        return "<div class=\"liste-de-posts\">{$res}</div>";
    }
}