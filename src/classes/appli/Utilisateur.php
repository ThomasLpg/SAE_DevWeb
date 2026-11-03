<?php

namespace iutnc\iks\appli;

class Utilisateurs{

    private string $pseudo;

    function __construct(string $ps){
        $this->pseudo = $ps;
    }
}