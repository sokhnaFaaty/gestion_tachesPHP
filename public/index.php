<?php
// public/index.php

define("WEBROOT", "http://localhost:8003/");
define("ROOT", str_replace("public", "", $_SERVER['DOCUMENT_ROOT']));

require_once ROOT . "env.dev.php";
require_once ROOT . "/config/helpers.php";
require_once ROOT . "/config/validators.php";
require_once ROOT . "/routes/web/router.php";