<?php 

namespace iutnc\iks\repo;

class ImageRepository extends IksRepository {
    public static ?IksRepository $instance = null;

    public function insererImage(string $nom){
        $query = "INSERT IGNORE INTO Image(cheminFichier) VALUES (:chemin)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['chemin' => $nom]);
    }

    

}