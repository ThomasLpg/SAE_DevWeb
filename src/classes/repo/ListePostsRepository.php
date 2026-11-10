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

}