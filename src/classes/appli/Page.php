<?php

class Page {
    
    private Array $listePost = [];
    

    function __construct(private int $nbPostParPage = 3){
    }

    function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exeption("$at : invalid property");
    }


    function ajouterIks(Post $post) : int {
        if (count($this->listePost) >= $nbPostParPage){
            return 0;
        }
        $this->listePost[] = $post;
        return 1;
    }

    
}