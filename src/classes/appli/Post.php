<?php

namespace iutnc\iks\appli;


class Post{
    private ?string $contenu = null;

    function __construct(private ?int $numPost = null,
                         private ?string $datePost = ""){

        $contenu = htmlspecialchars($texte, ENT_QUOTE, 'UTF-8');
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    

}