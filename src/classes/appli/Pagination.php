<?php

namespace iutnc\iks\appli;

class Pagination {
    private array $listeElts;
    private int $nbPages;
    private int $nbEltsParPage, $numPage;

    public function __construct(array $tab, int $nbEltsParPage = 3, int $numPage = 1){
        if ($nbEltsParPage <= 0){
            $this->nbEltsParPage = 1;
        } else if ($nbEltsParPage > count($tab)) {
            $this->nbEltsParPage = count($tab);
        } else {
            $this->nbEltsParPage = $nbEltsParPage;
        }
        $this->listeElts = $tab;
        $this->nbPages = (int) ceil(count($tab)/$nbEltsParPage);
        $this->numPage = $numPage;
        $this->verifierPageDemandee();
        if ($this->nbPages === 0){
            $this->nbPages = 1;
        }
    }

    public function verifierPageDemandee() : void{
        if ($this->numPage > $this->nbPages){
            $this->numPage = $this->nbPages;
        } else if ($this->numPage <= 0){
            $this->numPage = 1;
        }
    }

    public function getEltsPage() : array{
        return array_slice($this->listeElts, ($this->numPage-1)*$this->nbEltsParPage, $this->nbEltsParPage);
    }

    public function afficherPagination(string $action) : string {
        $res = "";
        if ($this->numPage - 1 >= 1){
            $pageprec = $this->numPage - 1;
            $res .= "<a href='?action=$action&page=$pageprec'>Précédent</a><br>";
        } 
        if ($this->numPage < $this->nbPages){
            $pagesuiv = $this->numPage + 1;
            $res .= "<a href='?action=$action&page=$pagesuiv'>Suivant</a>";
        }
        return $res;
    }


    public static function initierPage(array $tab){
        $nbPostsParPage = (int) ($_GET['nbPostsParPage'] ?? 3);
            
        $numPageActuelle = (int) ($_GET['page'] ?? 1);
        
        return new self($tab, $nbPostsParPage, $numPageActuelle);

        
}
}