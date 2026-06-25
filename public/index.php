<?php
// // public/web/index.php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
// $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
//             || ($_SERVER['SERVER_PORT'] ?? 80) == 443;
// $scheme = $isHttps ? 'https' : 'http';
// define("WEBROOT", $scheme . "://" . $host . "/");
// define("ROOT", dirname(__DIR__, 2) . "/");
// var_dump(ROOT);
// require_once ROOT . "config/config.php";
// require_once ROOT . "routes/web/router.php";
define("WEBROOT","http://localhost:8003/");
define("ROOT", str_replace("public","",$_SERVER['DOCUMENT_ROOT']));
if(session_status() == PHP_SESSION_NONE){session_start();}
// require_once ROOT."env.php";
require_once ROOT."/config/helpers.php";
require_once ROOT."/config/validators.php";
require_once ROOT."/routes/web/router.php";

