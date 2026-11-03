<?php

namespace iutnc\iks\appli;

class Utilisateurs{

    private string $pseudo;

    function __construct(string $ps){
        $this->pseudo = $ps;
    }

    public function suivreUtilisateur(Utilisateur $utilisateur):void {

    }

    public function publierPost(string $texte):void{

    }

    public function paginerPost():array{

    }

}