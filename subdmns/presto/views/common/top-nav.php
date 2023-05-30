    <nav class="top-nav">
<?php

use Back\Cross\Secs;

if ($logged_in) {
//     echo <<<HTML
//             <a class="top-nav__link lg--display-none" id="menu-btn">
//                 <img class="top-nav__image" src="/res/menu_light_64.png" alt="menu">
//             </a>
// HTML;
    echo "\t\t<div class='top-nav__left-links'>", PHP_EOL;

    foreach (Secs::cases() as $section) {
        if (in_array($user_role, $section->authRoles())) {
            echo "\t\t\t<a class='top-nav__link' href='/{$section->defViewUrl()}'>";
            if ($section === Secs::Home) {
                echo PHP_EOL, <<<HTML
                <img class="top-nav__image" src="/res/home_light_64.png" alt="home">
                <span>{$section->value}</span>
HTML;
            } else {
                echo $section->value;
            }
            echo '</a>', PHP_EOL;
        }
    }

    echo '</div>';
?>
        <div id="user-menu">
            <a id="user-btn" class="top-nav__link">
                <span><?php echo $_SESSION['user_name'] ?></span>
                <img class="top-nav__image" src="/res/usr_32.png" alt="login-img">
            </a>
            <div id="user-options">
                <!-- <a class="user-menu__option" >Info usuario</a> -->
                <!-- <a class="user-menu__option" >Cambiar contraseña</a> -->
                <a class="user-menu__option" id="logout-btn">Cerrar sesión</a>
            </div>
        </div>
<?php
}    
?>
    </nav>