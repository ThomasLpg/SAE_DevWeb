<?php

namespace iutnc\iks\appli;

class Suivre{

    function __construct(private string $mail,
                        private string $mailSuivi){} 

    function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exeption("$at : invalid property");
    }

    function setMail(string $m):void{
        $this->mail = $m;
    }

    function setMailSuivi(string $ms):void{
        $this->mailSuivi = $ms;
    }
}