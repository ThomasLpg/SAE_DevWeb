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
        if (isset($_SESSION['utilisateur'])){
            $user = $_SESSION['utilisateur'];
            $pseudo = filter_var($user->__get('pseudo'), FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $pseudo = "";
        }
        
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>IKS</title>
                <link rel="stylesheet" href="css/style.css">
            </head>
            <header><h1 class="nom-user">$pseudo</h1></header>
            <body>
                $html
            </body>
        </html>
        HTML;
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
