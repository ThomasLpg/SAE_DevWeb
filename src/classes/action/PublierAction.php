<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\UtilisateurRepository;
use iutnc\iks\appli\Post;

class PublierAction extends Action{
    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            return $this->renderformulaire();
        }


        var_dump($_SESSION);

        $contenu = filter_var($_POST['contenu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_SESSION['utilisateur'], FILTER_VALIDATE_EMAIL);
        $dest = null;


        $upload_dir = __DIR__ . '/img/';
        $filename = uniqid();
        $tmp = $_FILES['inputfile']['tmp_name'] ;

        if (isset($_FILE['inputfile']) && $_FILES['inputfile']['error'] === UPLOAD_ERR_OK){
            $nomFichier = uniqid() . '.png';
            $dest = '/upload' . $nomFichier.'.png';

        }

        $post = new Post($contenu, $_SESSION['utilisateur'], $dest);

        try{
            $repo = UtilisateurRepository::getInstance();
            $repo->publierPost($post);
            
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }


    function renderFormulaire() : string{
        return <<<HTML
        <form id="f1" method="post"
            action="index.php?action=publier-post"
            enctype="multipart/form-data">

            <input type="text" name="contenu" placeholder="Ajouter un Iks" required>
            <input type="file" name="inputfile"> 
                        
            <button type="submit" name="publier-post" 
            value="validation-form-add">Publier</button>
        </form>
        HTML;   
    }
}