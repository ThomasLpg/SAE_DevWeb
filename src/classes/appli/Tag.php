<?php

namespace iutnc\iks\appli;

class Tag{
    private string $dateTag = "";

    function __construct(){
        
    }

    function __get(string $at) : mixed {
        if(property_exists($this, $at))
            return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    

}