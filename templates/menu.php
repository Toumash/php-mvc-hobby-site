<ul id="menu">
    <?php
    foreach ($this->get('menu-items') as $item) {
        echo '<li><a href="' . $item['url'] . '">' . $item['name'] . '</a></li>';
    }
    ?>
</ul>