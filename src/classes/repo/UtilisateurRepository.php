<?php

namespace iutnc\iks\repo;
use iutnc\iks\appli\Post; 

class UtilisateurRepository extends IksRepository{
    public function publierPost(Post $post): Post{
        $query = "INSERT INTO Post(contenu, mail, cheminFichier) VALUES (:contenu, :mail, :cheminFichier )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['contenu' => $post->__get('contenu'),
                        'mail' => $post->__get('mail'),
                        'cheminFichier' => $post->__get('cheminFichier')]);
        $post->setID($this->pdo->lastInsertId());
    }
   
}
