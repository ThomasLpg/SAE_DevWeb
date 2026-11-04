<?php

namespace iutnc\iks\appli;

class ContenuTag{

    function __construct(private int $identifiantT,
                        private int $numPost){}

    function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    function setIdentifiantT(int $i):void{
        $this->identifiantT = $i;
    }

    function setNumPost(int $n):void{
        $this->numPost = $n;
    }
}//testgit