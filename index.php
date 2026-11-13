<?php

declare(strict_types=1);

use iutnc\iks\dispatch\Dispatcher;

use iutnc\iks\action as ac;
use iutnc\iks\repo\IksRepository;

require_once('vendor/autoload.php');

session_start();

IksRepository::setConfig(__DIR__ . '/config.ini');

$dispatcher = new Dispatcher();
$dispatcher->addRoute('afficher-abos', ac\AfficherAbosAction::class);
$dispatcher->addRoute('afficher-post', ac\AfficherListeIksAction::class);
$dispatcher->addRoute('publier-post', ac\PublierAction::class);
$dispatcher->addRoute('authentifier', ac\AuthentificationAction::class);
$dispatcher->addRoute('rechercher', ac\RechercherAction::class);
$dispatcher->addRoute('pourtoi', ac\AfficherMurUtilisateur::class);
$dispatcher->addRoute('suivre-utilisateur', ac\SuivreUtilisateurAction::class);
$dispatcher->addRoute('ne-plus-suivre-utilisateur', ac\SeDesabonnerUtilisateurAction::class);
$dispatcher->addRoute('suivre-tag', ac\AbonnerTagAction::class);
$dispatcher->addRoute('ne-plus-suivre-tag', ac\SeDesabonnerTagAction::class);
    
$dispatcher->run(); 