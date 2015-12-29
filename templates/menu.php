<ul id="menu">
    <?php
    $items = $this->get('menu-items');
    foreach ($items as $item) {
        echo '<li><a href="' . $item['url'] . '">' . $item['name'] . '</a></li>';
    }
    ?>
</ul>