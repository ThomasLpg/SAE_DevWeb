<?php

namespace iutnc\iks\appli;

class Utilisateurs{

    private ?int $nbIks = 0;
    
    function __construct(private string $mail,
                        private string $nom,
                        private string $prenom,
                        ){
    }

    function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    function setNom(string $n):void{
        $this->nom = $n;
    }

    function setPrenom(string $p):void{
        $this->prenom = $p;
    }

    function setMail(string $m):void{
        $this->mail = $m;
    }

    function setNbIks(int $nb):void{
        $this->nbIks = $nb;
    }
}