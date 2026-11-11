<?php

namespace iutnc\iks\appli;

use iutnc\iks\repo\UtilisateurRepository;
use iutnc\iks\repo\SuivreRepository;

class ListePosts{

    function __construct(private array $liste = []){}

    function ajouterPost(Post $post): void{
        $this->liste[] = $post;
    }

    function supprimerPost(Post $post): void{
        foreach($this->liste as $index => $actuelPost){
            if($actuelPost == $post){
                unset($this->liste[$index]);
                break;
            }
        }
    }

    function getPost(int $n): Post{
        return $this->liste[$n];
    }

    function getListe() : array{
        return $this->liste;
    }

    function afficherPostsCourt(): string{     
        $res = "";
        try {
            $repoSuivre = SuivreRepository::getInstance();
            // On récupère la liste des utilisateurs suivis par l'utilisateur actuel
            $users_suivis = $repoSuivre->getSuivisUser($_SESSION['utilisateur']->__get('mail'));
        } catch (\Exception $e){
            return $e->getMessage();
        }
       
        // A chaque poste qu'on veut afficher, on vérifie si l'auteur du post est suivi par l'utilisateur actuel
        // Si oui : alors rien ne se passe, on affiche le poste normalement
        // Si non : alors on ajoute un bouton suivre qui permet de suivre l'utilisateur
        

        foreach($this->liste as $p){
            $suivre = "";
            $court = $p->renderCourt();
            $long = $p->render();
            $user = $p->__get('auteur');
            $pseudo = $user->__get('pseudo');
            $date = $p->__get('datePub');
            $mail= $user->__get('mail');
            if (!in_array($mail, $users_suivis, true) && ($pseudo !== $_SESSION['utilisateur']->__get('pseudo'))) {
                $suivre = "<a href='?action=suivre-utilisateur&suivi={$pseudo}'>Suivre</a>";
            }

            $res .= "
            <a href='?action=rechercher&info-a-rechercher={$mail}' class=\"auteur-iks\">{$pseudo}</a>
            <details>
                <summary class=\"post-affichage\"> 
                    <span class=\"version-courte\">{$court}</span>
                    <span class=\"version-longue\">{$long}</span>
                </summary>
            
            </details>
            <h3>{$suivre}</h3>
            <div class=\"date-iks\">{$date}</div>
            <br>";
        }

        return "<div class=\"liste-de-posts\">{$res}</div>";
    }
}