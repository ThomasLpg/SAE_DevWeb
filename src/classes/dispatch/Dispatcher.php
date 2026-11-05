<?php
namespace iutnc\iks\dispatch;

//Reprit des TD de cours

class Dispatcher{
    protected ?string $action;
    protected array $routes = [ ];
    
    function __construct(){
        if(isset($_GET[('action')])){
            $this->action = $_GET['action'];
        }
        else{
            $this->action = 'authentifier';
        }
    }

    function renderPage($html){
        echo "<!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset= \"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>Document</title>
        </head>

        <body>
            $html
        </body>
        </html>";
    }

    function run() : void{
        if(isset($this->routes[$this->action])){
            $actionClass = $this->routes[$this->action];
            $actionInstance = new $actionClass();
            $html = $actionInstance->execute();
            $this->renderPage($html);
        }
    }

    function addRoute(string $action, string $class): self{
        $this->routes[$action] = $class;
        return $this;
    }

    
}
