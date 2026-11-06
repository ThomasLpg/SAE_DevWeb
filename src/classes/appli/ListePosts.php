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

    function getPost($numPost): Post{
        foreach($this->liste as $index => $actuelPost){
            $post = null;
            if($actuelPost->__get('numPost') == $numPost){
                $post = $actuelPost;
            }
        }
    }

    function getListe() : array{
        return $this->liste;
    }
}