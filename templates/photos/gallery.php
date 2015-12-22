<form action="?c=photo&action=upload" method="post" enctype="multipart/form-data">
    <input type="file" name="file" id="file">
    <input type="text" name="watermark" id="watermark">
    <input type="submit" value="Wrzuć" name="submit">
</form>


<?php
/** @var Photo $photo */
$photos = $this->get('photos');
if (!empty($photos)) {
    foreach ($photos as $photo) {
        echo "<a href=\"{$photo->watermarkUrl}\"><img src=\"{$photo->thumbnailUrl}\" title=\"{$photo->title}\"/></a>";
        echo "<span>{$photo->user->name}</span>";
        // TODO: better user experience
    }
} else {
    echo "<h2>Brak zdjęć</h2>";
}
?>
<h3>This need to be optimized in PHP for better experience</h3>
