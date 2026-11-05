<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\UtilisateurRepository;
use iutnc\iks\appli\Post;

class PublierAction extends Action{
    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           var_dump($_SESSION);

            $contenu = filter_var($_POST['contenu'], FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($_SESSION['utilisateur'])) {
            return "<p>Vous devez vous connecter avant de pouvoir
            publier un Iks. <a href='index.php?action=authentifier'>Se connecter</a></p>";
}
            $user = $_SESSION['utilisateur'];

            $email = filter_var($user->__get('mail'), FILTER_VALIDATE_EMAIL);

            $dest = null;


            $upload_dir = __DIR__ . '/img/';
            $filename = uniqid();
            $tmp = $_FILES['inputfile']['tmp_name'] ;

            if (isset($_FILES['inputfile']) && $_FILES['inputfile']['error'] === UPLOAD_ERR_OK){
                $nomFichier = uniqid() . '.png';
                $dest = '/upload' . $nomFichier.'.png';

            }

            $post = new Post($contenu, $email, $dest);

            try{
                $repo = UtilisateurRepository::getInstance();
                $repo->publierPost($post);
                
            } catch(\Exception $e){
                return $e->getMessage();
            }
            header('Location: index.php?action=default');
            exit;
        }
         return $this->renderformulaire();
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