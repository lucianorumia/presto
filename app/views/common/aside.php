    <aside class="navigator">
        <ul id="navigator-list" class="navigator__list">
            <?php
            if ($logged_in) {
                switch ($_SESSION['role_id']) {
                    case 1: 
                        $views_array = DIR_VIEWS;
                        break;
                }

                foreach ($views_array as $view) {
                    echo '<a class="navigator__link" href="/' . $view->value . '">' . $view->caption() . '</a>';
                }
            }
            ?>
        </ul>
    </aside>