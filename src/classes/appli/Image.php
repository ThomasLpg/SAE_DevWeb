<?php

namespace iutnc\iks\appli;

class Image{

    function __construct(private string $descriptionImage,
                        private string $cheminFichier){}

    function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exeption("$at : invalid property");
    }
}