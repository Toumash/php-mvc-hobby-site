<ul id="menu">
    <?php
    foreach ($this->get('menu-items') as $item => $value) {
        echo '<li><a href="' . $value . '">' . $item . '</a></li>';
    }
    ?>
</ul>