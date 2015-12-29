<?php
$isLogged = $this->get('logged');
/** @var Photo[] $photos */
$photos = $this->get('photos');
$error = $this->get('photo-upload-error');


?>
<a href="<?php echo $this->generateUrl('photo', 'finder'); ?>">Wyszukiwarka Zdjęć</a>

<div style="margin-bottom: 2em;">
    <form action="<?php echo $this->generateUrl('photo', 'upload'); ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="title" id="title" placeholder="Tytul" required/>
        <?php if ($isLogged): ?>
            <input type="text" name="author" id="author" placeholder="Autor" required/>
        <?php endif; ?>
        <br/>
        <input type="text" name="watermark" id="watermark" placeholder="Znak wodny" required/>
        <input type="file" name="file" id="file" required/>
        <?php if ($isLogged): ?>
            Prywatność:
            <label>Publiczne><input type="radio" name="public" id="author" value="true" checked="checked"/></label>
            <label>Prywatne<input type="radio" name="public" id="author" value="false"/></label>
        <?php endif; ?>
        <input type="submit" value="Wrzuć" name="submit"/>
    </form>
</div>

<?php
if (!empty($error)) {
    echo "<span style='color:red''>" . htmlentities($error) . "</span>";
}
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
<a href="<?php echo $this->generateUrl('photo', 'remembered') ?>">Pokaż zapamiętane</a>

