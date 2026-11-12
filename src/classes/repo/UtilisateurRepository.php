<?php

namespace iutnc\iks\repo;
use iutnc\iks\appli\Post; 
use iutnc\iks\appli\Utilisateur;

class UtilisateurRepository extends IksRepository{
    public static ?IksRepository $instance = null;

    public function InsererUtilisateur(string $email, string $nom, string $prenom, string $pseudo): Utilisateur{
        //On selectionne l'utilisateur qui possède cet email
        $queryVerif = "SELECT mail, nom, prenom, pseudo, nbIks FROM Utilisateur WHERE mail = :mail";
        $stmtVerfif = $this->pdo->prepare($queryVerif);
        $stmtVerfif->execute(['mail' => $email]);
        $lignes = $stmtVerfif->fetch(\PDO::FETCH_ASSOC);
        
        //Si l'utilisateur existe, on reconstruit l'objet utiisateur à partir de la bd 
        if($lignes){
            $user = new Utilisateur($lignes['mail'], $lignes['nom'], $lignes['prenom'], $lignes['pseudo']);
            $user->setNbIks($lignes['nbIks']);
            return $user;
        }

        //Sinon on en crée un nouveau
        $query = "INSERT INTO Utilisateur(mail, nom, prenom, pseudo) VALUES (:mail, :nom, :prenom, :pseudo )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $email,
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'pseudo' => $pseudo]);
        //Nombre d'Iks null nouveau user

        return new Utilisateur($email, $nom, $prenom, $pseudo);
    }

    function getUtilisateur(string $email): ?Utilisateur{
        $query = "SELECT mail, nom, prenom, pseudo FROM Utilisateur WHERE mail=:mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $email]);

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new Utilisateur($data['mail'], $data['nom'], $data['prenom'], $data['pseudo']);
        if (isset($data['nbIks'])) {
            $user->setNbIks($data['nbIks']);
        }

        return $user;
    }


    
}
