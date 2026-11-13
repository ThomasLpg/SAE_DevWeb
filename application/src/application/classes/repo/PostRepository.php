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
        $stmtDate = $this->pdo->prepare($queryDate);
        $stmtDate->execute(['id' => $idPost]);

        $datePost = $stmtDate->fetchColumn();
        

        //Si il y a bien une date (ce qui est censé être vrai pour tout post)
        if($datePost !==false){
            //On donne la date à l'objet Post
            $post->setDatePub($datePost);
        }
        $this->traiterHashtags($idPost, $post->__get('contenu'));
        return $post;
    }

    public function getNbLikesMoyen(string $mail) : float{
        $query = "SELECT SUM(nblikes) as somme, count(numpost) as nbposts FROM Post WHERE mail=:mail";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['mail' => $mail]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if((!$user) || ($user['nbposts'] === 0)){
            return 0;
        } 
        return ($user['somme'] / $user['nbposts']);
    }



    public function traiterHashtags(int $idPost, string $contenu): void{
        preg_match_all('/#([a-zA-Z0-9]+)/u', $contenu, $matches);

        if(!empty($matches[1])){
            $hashtags = $matches[1];
            $tagRepo = TagRepository::getInstance();

            foreach($hashtags as $libelle){
                $idTag = $tagRepo->trouverOuCreerTag($libelle);
                $tagRepo->associerTagPost($idTag, $idPost);
            }
        }
    }

}