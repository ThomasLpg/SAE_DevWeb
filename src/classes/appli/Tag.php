<?php

namespace iutnc\iks\appli;

class Tag{
    private string $libelle;
    private string $descriptionTag;
    private int $identifiantT;

    function __construct(private int $identifiant,
                        private string $libel,
                        private string $description
                        ){
        
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    function setIdentifiant(int $i):void{
        $this->identifiant = $i;
    }

    function setLibel(int $l):void{
        $this->libel = $l;
    }

    function setDescription(int $d):void{
        $this->description = $d;
    }
}