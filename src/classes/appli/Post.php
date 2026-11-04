<?php

namespace iutnc\iks\appli;

class Post{
    
    private int $numPost;
    private string $datePub;

    function __construct(private string $contenu,
                         private string $mail,
                         private ?string $cheminFichier = null,
                         ){
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    function setContenu(String $c):void{
        $this->contenu = $c;
    }

    function setNumPost(int $np):void{
        $this->numPost = $np;
    }

    function setDatePub(String $d):void{
        $this->datePub = $d;
    }

    function setMail(String $m):void{
        $this->mail = $m;
    }

    function setCheminFichier(String $cf):void{
        $this->cheminFichier = $cf;
    }
}