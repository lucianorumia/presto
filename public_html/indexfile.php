<?php

use Back\Cross\Router;
use Back\Cross\UserRoles;
use Back\Cross\ViewHandler;
use Back\Cross\Security;

session_start();
require __DIR__ . '/../app/cross/router.php'; // Hardcode ref!

$logged_in = isset($_SESSION['user_id']);
$user_role = $logged_in ? UserRoles::tryFrom($_SESSION['user_role_id']) : null;

$url_view = isset($_GET['view']) ? strtolower($_GET['view']) : null;
$url_id = isset($_GET['id']) ? strtolower($_GET['id']) : null;
$url_act = isset($_GET['act']) ? strtolower($_GET['act']) : null;

$view_handler = new ViewHandler($logged_in, $user_role, $url_view, $url_id, $url_act);
$view_data = $view_handler->getViewData();

$security = new Security;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presto</title>
    <link rel="icon" type="image/x-icon" href="/res/favicon_64.png">
<?php
    // Import fonts
    // include Router::getFilePath('Back\Views\Common\Fonts');
    // echo PHP_EOL;

    // Set CSS file
    echo "\t<link rel='stylesheet' href='{$view_handler->cssFilepath()}'>" . PHP_EOL;

    // Set JS files
    echo "\t<script defer type='module' src='/js/template.js'></script>" . PHP_EOL;
    echo "\t<script defer type='module' src='{$view_handler->jsFilepath()}'></script>" . PHP_EOL;
?>
</head>
<body>
<?php
    include Router::getFilePath('Back\Views\Common\Noscript');
    echo PHP_EOL;
    include Router::getFilePath('Back\Views\Common\TopNav');
    echo PHP_EOL;
    // include Router::getFilePath('Back\Views\Common\Aside');
    // echo PHP_EOL;
?>
    <div class="curtain sprclss--display-none lg--display-none" id="curtain"></div>
    <main class="main-container">
<?php
    include $view_handler->viewFilepath();
    echo PHP_EOL;
?>
    </main>
<?php
    include Router::getFilePath('Back\Views\Common\Footer');
    echo PHP_EOL;
?>
    <dialog class="modal"></dialog>
</body>
</html>
