<?php

namespace iutnc\iks\appli;

class Tag{
    private string $libelle;
    private string $descriptionTag;
    private int $identifiantT;

<<<<<<< HEAD
    function __construct(private int $identifiant,
                        private string $libel,
                        private string $description
                        ){
        
=======
    function __construct(int $id, string $libelle, string $descriptionTag){
>>>>>>> 5246ca878a7ebe6a9b64468c7b5fcd70953dc7fb
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

<<<<<<< HEAD
    function setIdentifiant(int $i):void{
        $this->identifiant = $i;
=======
    function setLibelle (string $l) : void {
        $this->libelle = $l;
    }    

    function setDescriptionTag (string $dT) : void {
        $this->descriptionTag = $dT;
    }

    function setIdentifiantT (int $iT) : void {
        this->identifiantT = $iT;
>>>>>>> 5246ca878a7ebe6a9b64468c7b5fcd70953dc7fb
    }

    function setLibel(int $l):void{
        $this->libel = $l;
    }

    function setDescription(int $d):void{
        $this->description = $d;
    }
}