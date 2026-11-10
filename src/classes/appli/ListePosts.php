<?php

namespace iutnc\iks\appli;

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
        $listePosts = $this->liste;

        $res = "";

        foreach($listePosts as $p){
            $court = $p->renderCourt();
            $long = $p->render();
            // $auteur = $p->
            $date = $p->__get('datePub');

            // <div class=\"auteur-iks\">{$auteur}</div>
            $res .= "
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