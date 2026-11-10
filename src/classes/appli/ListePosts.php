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
}