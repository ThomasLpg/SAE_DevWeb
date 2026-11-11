<?php

namespace iutnc\iks\repo;

class TagRepository extends  IksRepository{
    public static ?IksRepository $instance =null;

    public function trouverOuCreerTag(string $libelle){
        $query = "SELECT identifiantT FROM Tag WHERE `libellé` = :libelle";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['libelle' => $libelle]);
        $idTag = $stmt->fetchColumn();

        if(!$idTag){
            $insertion = "INSERT INTO Tag (`libellé`) VALUES (:libelle)";
            $stmt2 = $this->pdo->prepare($insertion);
            $stmt2->execute(['libelle' => $libelle]);
            $idTag = $this->pdo->lastInsertId();
        }

        return (int) $idTag;

    }

    public function associerTagPost (int $idTag, int $idPost){
        $query = "INSERT INTO ContenuTag (identifiantT, numPost) VALUES (:idTag, :idPost)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'idTag' => $idTag,
            'idPost' => $idPost
        ]);
    }

    public function sabonnerTag(string $libelleTag){
        
    }
    
}