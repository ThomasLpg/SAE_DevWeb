<?php

namespace iutnc\iks\action;

class PublierAction extends Action{
    function execute() : string{
        return <<<FIN
        <p>Nouvelle publication</p> 
        <select name = "Post">
            ...
        </select>
        FIN;   
    }
}