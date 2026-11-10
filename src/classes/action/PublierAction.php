<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\PostRepository;
use iutnc\iks\appli\Post;
use iutnc\iks\appli\Utilisateur;

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
            $nom = filter_var($user->__get('nom'), FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_var($user->__get('prenom'), FILTER_SANITIZE_SPECIAL_CHARS);
            $pseudo = filter_var($user->__get('pseudo'), FILTER_SANITIZE_SPECIAL_CHARS);

            $dest = null;


            $upload_dir = __DIR__ . '/img/';
            $filename = uniqid();
            $tmp = $_FILES['inputfile']['tmp_name'] ;

            if (isset($_FILES['inputfile']) && $_FILES['inputfile']['error'] === UPLOAD_ERR_OK){
                $nomFichier = uniqid() . '.jpeg';
                $dest = '/upload' . $nomFichier.'.jpeg';

            }

            $post = new Post($contenu, $email, new Utilisateur($email, $nom, $prenom, $pseudo), $dest);

            try{
                $repo = PostRepository::getInstance();
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

            <textarea name="contenu" maxlength="235" rows="10" placeholder="Ajouter un Iks" required> </textarea>
            <input type="file" name="inputfile"> 
                        
            <button type="submit" name="publier-post" 
            value="validation-form-add">Publier</button>
        </form>
        HTML;   
    }
}