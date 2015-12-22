<h1><? echo $this->get('user-name'); ?></h1>


<?php
/** @var Photo $photo */
foreach ($this->get('photos') as $photo) {
    echo '<img src="{$photo->url}" title="{$photo->title}"/>';
    echo '<span>' . $photo->user->name . '</span>';
    // TODO: better user experience
}
?>
<h3>This need to be optimized in PHP for better experience</h3>
