<?php

namespace iutnc\iks\appli;


class Post{
    private string $contenu = "";

    function __construct(private int $numPost,
                         private string $datePub,
                         private string $mail,
                         private ?string $cheminFichier = null){

        $contenu = htmlspecialchars($texte, ENT_QUOTE, 'UTF-8');
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exeption("$at : invalid property");
    }
}