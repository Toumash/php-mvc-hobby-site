<h1><? echo $this->get('user-name'); ?></h1>


<?php
/** @var Photo $photo */
$photos = $this->get('photos');
if (!empty($photos)) {
    foreach ($photos as $photo) {
        echo "<img src=\"{$photo->originalUrl}\" title=\"{$photo->title}\"/>";
        echo "<span>{$photo->ownerId->name}</span>";
        // TODO: better user experience
    }
} else {
    echo "<h2>Brak zdjęć</h2>";
}
?>
<h3>This need to be optimized in PHP for better experience</h3>
