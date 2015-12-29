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
    ?>
    <form method="post" action="<?php echo $this->generateUrl('photo', 'remember'); ?>">
        <?php
        foreach ($photos as $photo):
            ?>
            <div><a href=" <?php echo $photo->watermarkUrl ?>"><img src=" <?php echo $photo->thumbnailUrl ?>"
                                                                    title="<?php echo $photo->title ?>"/></a>
                <span><?php echo $photo->author ?></span>
                <input type="checkbox" name="photo[]" value="<?php echo $photo->id ?>" title="Save Image"/>
            </div>
        <?php endforeach; ?>
        <input type="submit" value="Zapamiętaj Wybrane!"/>
    </form>
    <?php
} else {
    echo "<h2>Brak zdjęć</h2>";
}
?>

