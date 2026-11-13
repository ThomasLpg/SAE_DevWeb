<?php

namespace iutnc\iks\appli;

class ListePage{

    function __construct(private array $liste = []){}

    function ajouterPage(Page $page): void{
        $this->liste[] = $page;
    }

    function supprimerPage(Page $page): void{
        foreach($this->liste as $index => $actuelPage){
            if($actuelPage == $page){
                unset($this->liste[$index]);
                break;
            }
        }
    }

    function getPage(int $n): Page{
        return $this->liste[$n-1];
    }

    function getListe() : array{
        return $this->liste;
    }
}