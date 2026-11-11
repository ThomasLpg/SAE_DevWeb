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
        $users = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!$users){
            return [];
        } 
        return $users;

    }
    
    public function getSuivisUser(string $mail) : array {
        $query = "SELECT mailsuivi FROM Suivre WHERE mail=:mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail]);
        $users = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!$users){
            return [];
        } 
        return $users;
    }

    
}
