<?php

namespace iutnc\iks\action;

class DefaultAction extends Action{
    function execute() : string{
        return <<<FIN
            <a href=?action=afficher-liste-Iks role="button">Liste d'Iks</a>
            <a href=?action=publier-post role="button">Ajouter un poste</a>
            <a href=?action=authentifier role="button">Se Connecter / S'inscrire</a>
        FIN;
    }

}