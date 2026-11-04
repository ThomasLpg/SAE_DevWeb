<?php
class UtilisateurRepository extends IksRepository{
    public function publierPost(Post $post): Post{
        $query = "INSERT INTO Post(numPost ,cheminFichier, contenu, datepub, mail) VALUES (:numPost, :cheminFichier, :contenu, :datepub, :mail )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['numPost' => $post->__get('NumPost'),
                        'cheminFichier' => $post->__get('CheminFichier'),
                        'contenu' => $post->__get('Contenu'),
                        'datepub' => $post->__get('DatePub'),
                        'mail' => $post->__get('Mail')]);
        $post->setID($this->pdo->lastInsertId());
    }
   
}
