<?php

namespace iutnc\iks\appli;

class Post{
    
    private int $numPost;
    private string $datePub;
    

    function __construct(private string $contenu,
                         private string $mail,
                         private Utilisateur $auteur,
                         private ?string $cheminFichier = null,
                         ){
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exception("$at : invalid property");
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

    function renderCourt(): string{
        return substr($this->contenu, 0, 35); 
    }

    function render(): string{
        return $this->contenu;
    }
}   