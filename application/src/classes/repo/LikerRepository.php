<?php

namespace iutnc\iks\repo;

class LikerRepository extends IksRepository{
    public static ?IksRepository $instance = null;

    public function liker(string $mail, int $numPost) : bool{

        if($this->dejaLiker($mail, $numPost)){
            return false;
        }

        $query = "INSERT INTO Liker(mail, numPost) VALUES (:mail, :numPost)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail,
                        'numPost' => $numPost]);
        return true;
    }

    public function unLiker(string $mail, int $numPost) : bool{

        if($this->dejaLiker($mail, $numPost)){
            $query = "DELETE FROM Liker
                    WHERE  mail = :mail AND numPost = :numPost";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['mail' => $mail,
                            'numPost' => $numPost]);
            return true;
        }
        return false;
    }

    public function dejaLiker(string $mail, int $numPost) : bool {
        $query = "SELECT mail FROM Liker WHERE mail = :mail AND numPost = :numPost";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail, 'numPost' => $numPost]);

        return $stmt->fetchColumn() !== false;
    }

    public function getnbLikes(int $numPost) : int {
        $query = "SELECT COUNT(mail) FROM Liker WHERE numPost = :numPost";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['numPost' => $numPost]);

        return (int) $stmt->fetchColumn(); 
    }

    public function getSuiviLike(string $mailUser) : array{
        $query = "SELECT numPost FROM Liker WHERE mail=:mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mailUser]);
        $posts_likes = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        if ($posts_likes === false) {
            return [];
        }
        return $posts_likes;
    }

}    