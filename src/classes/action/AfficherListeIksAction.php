<?php

namespace iutnc\iks\action;

class AfficherListeIksAction extends Action{
    function execute() : string{
        return <<<FIN
        <a href=?action=default role="button">Acceuil</a>
        <br>
        <p>BD liste de Iks en cours...</p> 
        <h3>Liste d'IKS : </h3>
        <select name = "liste-Iks">
            ...
        </select>
        FIN;   
    }
}