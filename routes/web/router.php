<?php

$controllers = [
    "tache" => "TacheController"
];

$controller = $_REQUEST["controller"] ?? "tache";
$action = $_REQUEST["action"] ?? "dashboard";

if (!array_key_exists($controller, $controllers)) {
    die("Contrôleur introuvable");
}

$className = $controllers[$controller];
$controllerFile = ROOT . "/controllers/" . $className . ".php";

if (!file_exists($controllerFile)) {
    die("Fichier contrôleur introuvable : " . $controllerFile);
}

require_once $controllerFile;

if (!class_exists($className)) {
    die("Classe introuvable : " . $className);
}

$controllerInstance = new $className();

if (!method_exists($controllerInstance, $action)) {
    die("Action introuvable : " . $action);
}

$controllerInstance->$action();