<?php


function dd($test) {
    echo "<pre>";
    var_dump($test);
    echo "</pre>";
    die("Yallah pitié");
}

function loadView(string $view, array $datas = [], string $layout = "base") {
    ob_start();
    extract($datas);
    require_once(ROOT . "/views/" . $view . ".php");
    $content = ob_get_clean();
    require_once ROOT . "/views/layouts/$layout.layout.php";
}

function redirectTo(string $controller, string $action, array $params = []): void {
    $url = WEBROOT . "?controller=$controller&action=$action";
    if ($params) {
        $url .= '&' . http_build_query($params);
    }
    header('Location:' . $url);
    exit();
}

function isConnected(): bool {
    return isset($_SESSION["user"]);
}

function auth(): void {
    if (!isConnected()) {
        redirectTo("auth", "login");
    }
}