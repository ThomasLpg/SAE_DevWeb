<?php

namespace iutnc\iks\repo;

class EvaluationRepository extends IksRespository{
    public static ?IksRepository $instance = null;

    public function evaluer (string $mail, int $numPost, int $note) : bool{

        if($this->dejaEvaluer($mail, $numPost)){
            return false;
        }

        $query = "INSERT INTO Evaluation(mail, numPost, note) VALUES (:mail, :numPost, ;note)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail,
                        'numPost' => $numPost,
                        'note' => $note]);
        return true;
    }

    public function dejaEvaluer(string $mail, int $numPost) : bool {
        $query = "SELECT 1 FROM Evaluation WHERE mail = :mail AND numPost = :numPost";
        $stmt = $this->pdo->prepare($query);
        $stmt = execute(['mail' => $mail, 'numPost' => $numPost]);

        return $stmt->fetchColumn() !== false;
    }

    public function getScore(int $numPost) : int {
        $query = "SELECT COALESCE(SUM(note),0) FROM Evaluation WHERE numPost = :numPost";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['numPost' => $numPost]);

        return (int) $stmt->fetchColumn(); 
    }

}    