<?php

namespace iutnc\iks\repo;
use iutnc\iks\appli\Post;

class PostRepository extends IksRepository{
    public static ?IksRepository $instance = null;

    public function publierPost(Post $post): Post{
        //Insertion du post dans la table Post
        $query = "INSERT INTO Post(contenu, mail, cheminFichier) VALUES (:contenu, :mail, :cheminFichier )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['contenu' => $post->__get('contenu'),
                        'mail' => $post->__get('mail'),
                        'cheminFichier' => $post->__get('cheminFichier')]);
        $idPost = $this->pdo->lastInsertId();
        $post->setNumPost($idPost);

        //Récupération de la date du post 
        $queryDate = "SELECT datepub FROM Post WHERE numPost = :id";
        $stmtDate = $this->pdo->prepare($query);
        $stmtDate->execute(['id' =>$idPost]);

        $datePost = $stmtDate->fetchColum();

        //Si il y a bien une date (ce qui est sencé être vrai pour tout post)
        if($datePost !==false){
            //On donne la date à l'objet Post
            $post->setDatePub($datePost);
        }

        return $post;
    }

}