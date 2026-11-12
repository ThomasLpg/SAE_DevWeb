<?php

namespace iutnc\iks\action;
use iutnc\iks\appli\Utilisateur;
use iutnc\iks\repo\UtilisateurRepository;


class AuthentificationAction extends Action{

    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] === 'GET'){        
            $_SESSION = [];  
            return $this->renderFormulaire();
            
        }
        if(isset($_SESSION['emailUser'])){
            $email = $_SESSION['emailUser'];   
        }else{
            $email = filter_var($_POST['email-auth'] ?? '', FILTER_VALIDATE_EMAIL);
            if(!$email){
                return "<div class='erreur'>email non valide</div>" . $this->renderFormulaire();
            }
            $_SESSION['emailUser'] = $email;

        }
        $user = null;

        try{
            $repo = UtilisateurRepository::getInstance();
            $user = $repo->getUtilisateur($email);
            

        } catch(\Exception $e){
            return '<p>Erreur : {$e->getMessage()}';
        }

        if($user==null){
            $nom = filter_var($_POST['nom-auth'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $prenom = filter_var($_POST['prenom-auth'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $pseudo = filter_var($_POST['pseudo-auth'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        
            if($nom==null||$prenom==null||$pseudo==null) return $this->renderFormulaireSuite();

            $user = new Utilisateur($_SESSION['emailUser'], $nom, $prenom, $pseudo);

            try{
                $repo = UtilisateurRepository::getInstance();
                $user = $repo->InsererUtilisateur($email, $nom, $prenom, $pseudo);

                unset($_SESSION['emailUser']);

                $_SESSION['utilisateur'] = $user;  

                header('Location: index.php?action=afficher-post');
                exit;

            }catch(\Exception $e){
                $erreur="";
                $e->getMessage();
                if(str_contains($e, 'unique_pseudo')){
                    $erreur = 'Ce pseudo est déjà utilisé';
                }
                return "{$erreur}" . $this->renderFormulaireSuite();
            }
        }else{
            $_SESSION['utilisateur'] = $user;  

            header('Location: index.php?action=afficher-post');
            unset($_SESSION['emailUser']);
            exit;
        }
        
    }


    function renderFormulaire() : string{
        return '
            <form id="f1" method="post"
                action="index.php?action=authentifier">

                <input type="email" name="email-auth" placeholder="Entrez Votre adresse Email" required>

                <button type="submit" name="email-valide" 
                value="validation-form-auth">Valider</button>
            </form>
            ';
    }

    function renderFormulaireSuite(){
        return '
            <form id="f1" method="post"
                action="index.php?action=authentifier">

                <input type="text" name="nom-auth" placeholder="Entrez nom" required>
                <input type="text" name="prenom-auth" placeholder="Entrez prénom" required>
                <input type="text" name="pseudo-auth" placeholder="Entrez pseudo" required>

                <button type="submit" name="email-valide" 
                value="validation-form-auth">Valider</button>
            </form>
            ';
    }
} 