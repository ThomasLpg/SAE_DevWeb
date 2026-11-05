<?php

namespace iutnc\iks\repo;
use iutnc\iks\appli\Post; 
use iutnc\iks\appli\Utilisateur;

class UtilisateurRepository extends IksRepository{
    public static ?IksRepository $instance = null;

    public function publierPost(Post $post): Post{
        $query = "INSERT INTO Post(contenu, mail, cheminFichier) VALUES (:contenu, :mail, :cheminFichier )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['contenu' => $post->__get('contenu'),
                        'mail' => $post->__get('mail'),
                        'cheminFichier' => $post->__get('cheminFichier')]);
        $post->setNumPost($this->pdo->lastInsertId());

        return $post;
    }

    public function authentificationOuInserer(string $email, string $nom, string $prenom): Utilisateur{
        //On selectionne l'utilisateur qui possède cet email
        $queryVerif = "SELECT mail, nom, prenom, nbIks FROM Utilisateur WHERE mail = :mail";
        $stmtVerfif = $this->pdo->prepare($queryVerif);
        $stmtVerfif->execute(['mail' => $email]);
        $lignes = $stmtVerfif->fetch(\PDO::FETCH_ASSOC);
        
        //Si l'utilisateur existe, on reconstruit l'objet utiisateur à partir de la bd 
        if($lignes){
            $user = new Utilisateur($lignes['mail'], $lignes['nom'], $lignes['prenom']);
            $user->setNbIks($lignes['nbIks']);
            return $user;
        }

        //Sinon on en crée un nouveau
        $query = "INSERT INTO Utilisateur(mail, nom, prenom) VALUES (:mail, :nom, :prenom )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $email,
                        'nom' => $nom,
                        'prenom' => $prenom]);
        //Nombre d'Iks null nouveau user

        return new Utilisateur($email, $nom, $prenom);
    }
   
}
