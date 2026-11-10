<?php

namespace iutnc\iks\repo;

use iutnc\iks\appli\ListePosts;
use iutnc\iks\appli\Post;


class ListePostsRepository extends IksRepository{
    public static ?IksRepository $instance = null;
    
    public function listePosts() : ListePosts{
        $query = "SELECT * FROM Post ORDER BY datepub DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        
        $lignes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $liste = new ListePosts();

        
        foreach($lignes as $ligne){
            $post = new Post($ligne['contenu'], $ligne['mail'], $ligne['cheminFichier']);
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
                ORDER BY POST.datepub DESC"
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['libelle' => $libel]);

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
        $query = "SELECT * FROM Post 
                    WHERE mail = :mail 
                    ORDER BY datepub DESC"

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail]);

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

}