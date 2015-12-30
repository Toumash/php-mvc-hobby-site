<?php
/** @var Photo $photo */
$photos = $this->get('photos');
if (!empty($photos)) {
    ?>
    <form method="post" action="<?php echo $this->generateUrl('photo', 'forget'); ?>">
        <?php
        foreach ($photos as $photo):
            ?>
            <div class="image"><a href=" <?php echo USR_IMG . $photo->watermarkName ?>"><img
                        src=" <?php echo USR_IMG . $photo->thumbnailName ?>"
                        title="<?php echo $photo->title ?>"/></a>
                <br/>
                <span><?php echo $photo->author ?></span>
                <input type="checkbox" name="photo[]" value="<?php echo $photo->_id ?>" title="Forget Image"/>
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Usuń zaznaczone z zapamiętanych"/>
    </form>
    <?php
} else {
    echo "<h2>Brak zapamiętanych zdjęć </h2>";
}
?>

