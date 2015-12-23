<div style="margin-bottom: 2em;">
    <form action="<?php echo $this->generateUrl('photo', 'upload'); ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="title" id="title" placeholder="Tytul" required/>
        <input type="text" name="author" id="author" placeholder="Autor" required/>
        <br/>
        <input type="text" name="watermark" id="watermark" placeholder="Znak wodny" required/>
        <input type="file" name="file" id="file" required/>
        <input type="submit" value="Wrzuć" name="submit"/>
    </form>
</div>

<?php
$error = $this->get('photo-upload-error');
if (!empty($error)) {
    echo "<span style='color:red''>" . htmlentities($error) . "</span>";
}
/** @var Photo $photo */
$photos = $this->get('photos');
if (!empty($photos)) {
    foreach ($photos as $photo) {
        echo "<a href=\"{$photo->watermarkUrl}\"><img src=\"{$photo->thumbnailUrl}\" title=\"{$photo->title}\"/></a>";
        echo "<span>{$photo->owner->name}</span>";
        // TODO: better user experience
    }
} else {
    echo "<h2>Brak zdjęć</h2>";
}
?>