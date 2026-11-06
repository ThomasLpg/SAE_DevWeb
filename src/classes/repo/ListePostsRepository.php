<?php

namespace iutnc\iks\repo;

use iutnc\iks\appli\ListePosts;

class ListePostsRepository extends IksRepository{
    public static ?IksRepository $instance = null;
    
    public function listePosts() : ListePosts{
        $query = "SELECT * FROM Post ORDER BY datepub DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($query);
        $lignes = $stmt->fetch(\PDO::FETCH_ASSOC);

        $liste = new LisePosts();

        
        foreach($lignes as $index){
            $post = new Post($ligne['contenu'], $ligne['mail'], $ligne['cheminFichier']);
            $post->setNumPost($ligne['numPost']);
            $post->setDatePub($ligne['datePub']);

            $liste->ajouterPost($post);
        }
        return $liste;
    }

}