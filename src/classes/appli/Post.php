<?php

namespace iutnc\iks\appli;

class Post{
    private string $text;
    private string $dateIks = "";
    private array $tag = [];

    function __construct(string $txt, string $d){
        $this->text = $txt;
        $this->dateIks = $d;
    }

}