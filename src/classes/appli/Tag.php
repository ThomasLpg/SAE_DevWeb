<?php

namespace iutnc\iks\appli;

class Tag{
    private string $libelle;
    private string $descriptionTag;
    private int $identifiantT;

    function __construct(int $id, string $libelle, string $descriptionTag){
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    function setLibelle (string $l) : void {
        $this->libelle = $l;
    }    

    function setDescriptionTag (string $dT) : void {
        $this->descriptionTag = $dT;
    }

    function setIdentifiantT (int $iT) : void {
        this->identifiantT = $iT;
    }

}