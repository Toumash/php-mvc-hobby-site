<ul id="menu">
    <?php
    /** @var MenuItem $item */
    foreach ($this->get('menu-items') as $item) {
        echo '<li><a href="' . $item['url'] . '">' . $item['name'] . '</a></li>';
    }
    ?>
</ul>