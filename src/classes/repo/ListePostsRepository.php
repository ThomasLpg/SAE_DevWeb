<?php

namespace iutnc\iks\repo;

use iutnc\iks\appli\ListePosts;
use iutnc\iks\appli\Post;
use iutnc\iks\appli\Utilisateur;


class ListePostsRepository extends IksRepository{
    public static ?IksRepository $instance = null;
    
    public function listePosts() : ListePosts{
        $query = "SELECT Post.*, Utilisateur.nom, Utilisateur.prenom, Utilisateur.pseudo FROM Post
        INNER JOIN Utilisateur ON Utilisateur.mail = Post.mail
        ORDER BY Post.datepub DESC";


        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        
        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $liste = new ListePosts();

        
        foreach($lignes as $ligne){
            $user = new Utilisateur($ligne['mail'], $ligne['nom'], $ligne['prenom'], $ligne['pseudo']);
            $post = new Post($ligne['contenu'], $ligne['mail'], $user, $ligne['cheminFichier']);
            $post->setNumPost($ligne['numPost']);
            $post->setDatePub($ligne['datepub']);

            $liste->ajouterPost($post);
        }
        return $liste;
    }

    public function listePostTag(string $libel):listePosts{
        $query = "SELECT * FROM POST 
                INNER JOIN CONTENUTAG ON POST.numPost = CONTENUTAG.numPost
                INNER JOIN TAG ON CONTENUTAG.identifiantT = TAG.identifiantT
                WHERE TAG.libelle = :libel
                ORDER BY POST.datepub DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['libelé' => $libel]);

        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $liste = new ListePosts();

        foreach($ligne as $ligne){
            $p = new Post($ligne['contenu'], $ligne['mail'], $ligne['cheminFichier']);
            $p->setNumPost($ligne['numPost']);
            $p->setDatePub($ligne['datePub']);
            $liste->ajouterPost($p);
        }
        return $liste;
    }

    public function listePostUtilisateur(string $mail):listePosts{
        $query = "SELECT Post.*, Utilisateur.nom, Utilisateur.prenom, Utilisateur.pseudo FROM Post
        INNER JOIN Utilisateur ON Utilisateur.mail = Post.mail
        WHERE Utilisateur.mail = :mail
        ORDER BY Post.datepub DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail]);

        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $liste = new ListePosts();

        
        foreach($lignes as $ligne){
            $user = new Utilisateur($ligne['mail'], $ligne['nom'], $ligne['prenom'], $ligne['pseudo']);
            $post = new Post($ligne['contenu'], $ligne['mail'], $user, $ligne['cheminFichier']);
            $post->setNumPost($ligne['numPost']);
            $post->setDatePub($ligne['datepub']);

            $liste->ajouterPost($post);
        }
        return $liste;
    }

    public function listePostsPourtoi($mail): ListePosts{
        $query = "SELECT DISTINCT Post.*, Utilisateur.nom, Utilisateur.prenom, Utilisateur.pseudo FROM Post
                 INNER JOIN Utilisateur ON Post.mail = Utilisateur.mail
                 LEFT JOIN ContenuTag  ON Post.numPost = ContenuTag.numPost
                 WHERE Post.mail IN(
                    SELECT mailsuivi FROM Suivre
                    WHERE mail = :mail)
                 OR ContenuTag.identifiantT IN(
                    SELECT identifiantT FROM AbonnerTag
                    WHERE mail = :mail2)
                ORDER BY Post.datepub DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'mail' => $mail,
            'mail2' => $mail
        ]);

        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $liste = new ListePosts;

        foreach($lignes as $ligne){
            $user = new Utilisateur($ligne['mail'],  $ligne['nom'], $ligne['prenom'], $ligne['pseudo']);
            $post = new Post($ligne['contenu'], $ligne['mail'], $user, $ligne['cheminFichier'] ?? null);
            $post->setNumPost($ligne['numPost']);   
            $post->setDatePub($ligne['datepub']);
            $liste->ajouterPost($post);
        }   
        return $liste;
    }

}