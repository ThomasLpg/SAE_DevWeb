<?php

namespace iutnc\iks\action;

class AuthentificationAction extends Action{
    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] === 'GET'){            
            return $this->renderFormulaire();
        }

        $email = filter_var($_POST['email-auth'], FILTER_VALIDATE_EMAIL);
        
        $_SESSION['utilisateur'] = $email;        

        return "Connecté";
    }


    function renderFormulaire() : string{
        return <<<HTML
            <form id="f1" method="post"
                action="index.php?action=authentifier">

                <input type="email" name="email-auth" placeholder="Entrez Votre adresse Email" required>

                <button type="submit" name="email-valide" 
                value="validation-form-auth">Valider</button>
            </form>
            HTML;
    }
} 