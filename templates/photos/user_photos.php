<?php
/** @var Photo[] $photos */
$photos = $this->get('photos');
$error = $this->get('photo-upload-error');
$userName = $this->get('user-name');

?>


<h1><? echo $userName ?></h1>


<?php
if (!empty($photos)) {
    foreach ($photos as $photo) {
        ?>
        <div><a href=" <?php echo USR_IMG . $photo->watermarkName ?>"><img
                    src=" <?php echo USR_IMG . $photo->thumbnailName ?>"
                    title="<?php echo $photo->title ?>"/></a>
            <span><?php echo $photo->isPublic() ? 'Publiczne' : 'Prywatne'; ?></span>
            <input type="checkbox" name="photo[]" value="<?php echo $photo->_id ?>" title="Save Image"/>
        </div>
        <?php
    }
} else {
    echo "<h2>Brak zdjęć</h2>";
}
?>
