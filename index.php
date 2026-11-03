<?php

declare(strict_types=1);

use iutnc\iks\dispatch\Dispatcher;
use iutnc\iks\action\DefaultAction;
use iutnc\iks\action\AfficherListeIksAction;

require_once('vendor/autoload.php');

$dispatcher = new Dispatcher();

$dispatcher->addRoute('default', DefaultAction::class);
$dispatcher->addRoute('afficher-liste-Iks', AfficherListeIksAction::class);


$dispatcher->run();