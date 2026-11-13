<?php

namespace iutnc\iks\action;
use iutnc\iks\repo\PostRepository;
use iutnc\iks\repo\ImageRepository;
use iutnc\iks\appli\Post;
use iutnc\iks\appli\Utilisateur;

class PublierAction extends Action{
    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if (empty($_SESSION['utilisateur'])) {
                return "<p>Vous devez vous connecter avant de pouvoir
                publier un Iks. <a href='index.php?action=authentifier'>Se connecter</a></p>";
            }
            $user = $_SESSION['utilisateur'];

            $email = filter_var($user->__get('mail'), FILTER_VALIDATE_EMAIL);
            $nom = filter_var($user->__get('nom'), FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_var($user->__get('prenom'), FILTER_SANITIZE_SPECIAL_CHARS);
            $pseudo = filter_var($user->__get('pseudo'), FILTER_SANITIZE_SPECIAL_CHARS);

            $chemin = null;
            if (isset($_FILES['inputfile']) && $_FILES['inputfile']['error'] !== UPLOAD_ERR_NO_FILE) {

                $fichier = $_FILES['inputfile'];

            
                if ($fichier['error'] !== UPLOAD_ERR_OK ||
                    $fichier['type'] !== 'image/jpeg') {

                    return "Erreur : le fichier sélectionné n'est pas un jpeg valide.";
                }


                $nomAleatoire = uniqid();  
                // dirname pour remonter de 3 dossiers depuis le dossier actuel          
                $upload_dir = dirname(__DIR__, 3) . '/images/';
                // Si le dossier n'existe pas, alors on le créé
                if (!is_dir($upload_dir)){
                    mkdir($upload_dir, 0755, true);
                }

                $destination = $upload_dir . $nomAleatoire . '.jpeg';


                if (move_uploaded_file($fichier['tmp_name'], $destination)) {

                
                    $chemin = 'images/' . $nomAleatoire . '.jpeg';
                    $repoImg = ImageRepository::getInstance();
                    $repoImg->insererImage($chemin);

                } else {
                    return "Erreur lors de l'enregistrement du fichier.";
                }
            }

            $post = new Post($_POST['contenu'], $email, new Utilisateur($email, $nom, $prenom, $pseudo), $chemin);

            try{
                $repo = PostRepository::getInstance();
                $repo->publierPost($post);
                
            } catch(\Exception $e){
                return $e->getMessage();
            }
            header('Location: index.php?action=afficher-post');
            exit;
        }
         return "<a class=accueil href='?action=afficher-post'>🏠Accueil</a>" . $this->renderformulaire();
    }


    function renderFormulaire() : string{
        return <<<HTML
        <form id="f1" method="post"
            action="index.php?action=publier-post"
            enctype="multipart/form-data">

            <div class=poster>
                <textarea name="contenu" maxlength="235" rows="10" placeholder="Ajouter un poste" required></textarea>
                <input class="fichier-post" type="file" name="inputfile" accept=".jpeg">         
                <button class="publier-bouton" type="submit" name="publier-post" value="validation-form-add">Publier</button>
            </div>
        </form>
        HTML;   
    }
}