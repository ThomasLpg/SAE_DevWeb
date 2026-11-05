<?php

namespace iutnc\iks\action;

class AfficherListeIksAction extends Action{
    function execute() : string{
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            
        }
        return $this->renderFormulaire();
    }

    function renderFormulaire() : string{
        return <<<HTML
        <a href=?action=default role="button">Accueil</a>
        <br>
        <p>BD liste de Iks en cours...</p> 
        <h3>Liste d'IKS : </h3>
        <select name = "liste-Iks">
            ...
        </select>
        HTML;
    }
}