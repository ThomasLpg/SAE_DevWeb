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

    function trouverTag(string $libelle){
        $query = "SELECT identifiantT FROM Tag WHERE `libellé` = :libelle";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['libelle' => $libelle]);
        $idTag = $stmt->fetchColumn();

        return (int) $idTag;
    }

    public function associerTagPost (int $idTag, int $idPost){
        $query = "INSERT IGNORE INTO ContenuTag (identifiantT, numPost) VALUES (:idTag, :idPost)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'idTag' => $idTag,
            'idPost' => $idPost
        ]);
    }

    public function sabonnerTag(string $mailUser, string $libelleTag) : bool{
        $queryRecupTag = "SELECT identifiantT FROM Tag 
                          WHERE libellé = :libelle";
        $stmtRecupTag = $this->pdo->prepare($queryRecupTag);
        $stmtRecupTag->execute(['libelle' => $libelleTag]);
        $idTag  = $stmtRecupTag->fetchColumn();

        if($idTag == false){
            return false;
        }

        $query = "INSERT IGNORE INTO AbonnerTag (identifiantT, mail) VALUES (:identifiantT, :mail)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'identifiantT' =>$idTag,
            'mail' =>$mailUser
        ]);
        return true;
    }

    public function seDesabonnerTag(int $idTag): void {
        $mailUser = $_SESSION['utilisateur']->__get('mail');

        $query = "DELETE FROM AbonnerTag
                  WHERE mail = :mail AND identifiantT = :identifiantT";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mailUser,
                        'identifiantT' => $idTag]);
    }


    public function estAbonne(string $mailUser, string $libelleTag): bool{
        $queryIdTag = "SELECT identifiantT FROM Tag
                       WHERE libellé = :libelle";
        $stmtIdTag = $this->pdo->prepare($queryIdTag);
        $stmtIdTag->execute(['libelle'=>$libelleTag]);
        $idTag = $stmtIdTag->fetchColumn();

        if($idTag==false){
            return false;
        }

        $query = "SELECT mail FROM AbonnerTag
                  WHERE identifiantT = :identifiantT 
                  AND mail = :mail";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'identifiantT' => $idTag,
            'mail' => $mailUser
        ]);
        $result = $stmt->fetchColumn();

        return $result !==false;

    }
    
    public function trouverPostParTag(string $tagName) {
        $query = "SELECT * FROM Post  
                INNER JOIN ContenuTag ON Post.numPost = ContenuTag.numPost 
                INNER JOIN Tag ON ContenuTag.identifiantT = Tag.identifiantT
                WHERE Tag.libellé = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$tagName]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Post::class);
    }
}