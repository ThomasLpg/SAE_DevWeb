<?php

declare(strict_types=1);

use iutnc\iks\dispatch\Dispatcher;
use iutnc\iks\action\AfficherListeIksAction;
use iutnc\iks\action\PublierAction;
use iutnc\iks\action\AuthentificationAction;
use iutnc\iks\action\AfficherAbosAction;
use iutnc\iks\action\RechercherAction;
use iutnc\iks\action\AfficherMurUtilisateur;
use iutnc\iks\repo\IksRepository;

require_once('vendor/autoload.php');

session_start();

IksRepository::setConfig(__DIR__ . '/config.ini');

$dispatcher = new Dispatcher();
$dispatcher->addRoute('afficher-abos', AfficherAbosAction::class);
$dispatcher->addRoute('afficher-post', AfficherListeIksAction::class);
$dispatcher->addRoute('publier-post', PublierAction::class);
$dispatcher->addRoute('authentifier', AuthentificationAction::class);
$dispatcher->addRoute('rechercher', RechercherAction::class);
$dispatcher->addRoute('pourtoi', AfficherMurUtilisateur::class);

$dispatcher->run(); 