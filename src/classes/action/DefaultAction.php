<?php

namespace iutnc\iks\action;

class DefaultAction extends Action{
    function execute() : string{
        return <<<FIN
            <a href=?action=afficher-liste-Iks role="button">Liste d'Iks</a>
        FIN;
    }

}