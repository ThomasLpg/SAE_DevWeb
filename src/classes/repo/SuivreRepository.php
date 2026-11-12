<?php

namespace iutnc\iks\repo;
use iutnc\iks\appli\Post; 
use iutnc\iks\appli\Utilisateur;

class SuivreRepository extends IksRepository{
    public static ?IksRepository $instance = null;

    public function getAbosUser(string $mail) : array {
        $query = "SELECT mail FROM Suivre WHERE mailsuivi=:mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail]);
        $users = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        if ($users === false) {
            return [];
        }
        return $users;

    }
    
    public function getSuivisUser(string $mail) : array {
        $query = "SELECT mailsuivi FROM Suivre WHERE mail=:mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail]);
        $users = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        if ($users === false) {
            return [];
        }
        return $users;
    }

    public function suivreUtilisateur(string $pseudo) : void {
        $mail = $_SESSION['utilisateur']->__get('mail');
        $query = "SELECT mail FROM Utilisateur WHERE pseudo = :p";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['p' => $pseudo]);
        $mailsuivi = ($stmt->fetch(\PDO::FETCH_ASSOC))['mail'];

        $query = "INSERT INTO Suivre(mail, mailsuivi) VALUES (:mail, :mailsuivi)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail,
                        'mailsuivi' => $mailsuivi]);
    }


    
}
