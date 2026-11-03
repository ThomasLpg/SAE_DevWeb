<?php
class UtilisateurRepository extends IksRepository{
    public function publierPost(Post $post): Post{
        $query = "INSERT INTO Post(numPost ,cheminFichier, contenu, datepub, mail) VALUES (:numPost, :cheminFichier, :contenu, :datepub, :mail )";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['numPost' => $post->getNumPost(),
                        'cheminFichier' => $post->getCheminFichier(),
                        'contenu' => $post->getContenu(),
                        'datepub' => $post->getDatePub(),
                        'mail' => $post->getMail()]);
        $post->setID($this->pdo->lastInsertId());
    }
   
}
