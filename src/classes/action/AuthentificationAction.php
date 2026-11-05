<?php

namespace iutnc\iks\action;
use iutnc\iks\appli\Utilisateur;
use iutnc\iks\repo\UtilisateurRepository;

class AuthentificationAction extends Action{
    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] === 'GET'){            
            return $this->renderFormulaire();
        }

        $email = filter_var($_POST['email-auth'], FILTER_VALIDATE_EMAIL);
        $nom = filter_var($_POST['nom-auth'], FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_var($_POST['prenom-auth'], FILTER_SANITIZE_SPECIAL_CHARS);
        
        $user = new Utilisateur($email, $nom, $prenom);
  
        
        try{
            $repo = UtilisateurRepository::getInstance();
            $user = $repo->authentificationOuInserer($email, $nom, $prenom);

            $_SESSION['utilisateur'] = $user;  

            header('Location: index.php?action=default');
            exit;

        }catch(\Exception $e){
            return $e->getMessage();
        }

    }


    function renderFormulaire() : string{
        return <<<HTML
            <form id="f1" method="post"
                action="index.php?action=authentifier">

                <input type="email" name="email-auth" placeholder="Entrez Votre adresse Email" required>
                <input type="text" name="nom-auth" placeholder="Entrez nom" required>
                <input type="text" name="prenom-auth" placeholder="Entrez prénom" required>

                <button type="submit" name="email-valide" 
                value="validation-form-auth">Valider</button>
            </form>
            HTML;
    }
} 