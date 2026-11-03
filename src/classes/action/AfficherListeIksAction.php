<?php

namespace iutnc\iks\action;

class AfficherListeIksAction extends Action{
    function execute() : string{
        return <<<FIN
        <p>BD liste de Iks en cours...</p> 
        <select name = "liste-Iks">
            ...
        </select>
        FIN;   
    }
}