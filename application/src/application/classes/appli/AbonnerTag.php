<?php

namespace iutnc\iks\appli;

class AbonnerTag {
    
    function __construct(private int $identifiantT,
                        private string $mail){}
    }

    function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    function setIdentifiantT(int $i):void{
        $this->identifiantT = $i;
    }

    function setMail(int $m):void{
        $this->mail = $m;
    }