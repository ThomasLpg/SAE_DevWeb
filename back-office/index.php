<?php 

declare(strict_types=1);

require_once('vendor/autoload.php');

use backoffice\admin\repo\StatistiquesRepository;
use backoffice\admin\dispatch\Dispatcher;
use backoffice\admin\action as ac;


StatistiquesRepository::setConfig(__DIR__ . '/config.ini');

$dispatcher = new Dispatcher();
$dispatcher->addRoute('default', ac\DefaultAction::class);
$dispatcher->addRoute('afficher-stats-users', ac\AfficherStatistiquesUsersAction::class);
$dispatcher->addRoute('afficher-stats-tags', ac\AfficherStatistiquesTagsAction::class);

$dispatcher->run();