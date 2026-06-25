<?php
$controllers = [
    "tache" => "tacheController",
    "auth" => "authController"
];

$controller = $_REQUEST["controller"] ?? "tache";
$action = $_REQUEST["action"] ?? "dashboard";

if (!array_key_exists($controller, $controllers)) {
    die("Contrôleur introuvable");
}

$controllerFile = ROOT . "/controllers/" . $controllers[$controller] . ".php";

if (!file_exists($controllerFile)) {
    die("Fichier contrôleur introuvable : " . $controllerFile);
}

require_once $controllerFile;

$functionName = $controller . ucfirst($action);

if (!function_exists($functionName)) {
    die("Action introuvable : " . $functionName);
}

$functionName();