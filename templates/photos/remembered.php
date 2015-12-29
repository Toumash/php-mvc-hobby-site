<?php
/** @var Photo $photo */
$photos = $this->get('photos');
if (!empty($photos)) {
    ?>
    <form method="post" action="<?php echo $this->generateUrl('photo', 'forget'); ?>">
        <?php
        foreach ($photos as $photo):
            ?>
            <div><a href=" <?php echo $photo->watermarkUrl ?>"><img src=" <?php echo $photo->thumbnailUrl ?>"
                                                                    title="<?php echo $photo->title ?>"/></a>
                <span><?php echo $photo->author ?></span>
                <input type="checkbox" name="photo[]" value="<?php echo $photo->id ?>" title="Forget Image"/>
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Usuń zaznaczone z zapamiętanych"/>
    </form>
    <?php
} else {
    echo "<h2>Brak zapamiętanych zdjęć </h2>";
}
?>

