<?php
$isLogged = $this->get('logged');
/** @var Photo[] $photos */
$photos = $this->get('photos');
$error = $this->get('photo-upload-error');
$rememberedPhotos = $this->get('remembered-photos');

?>
<h2>Galeria Zdjęć</h2>

<br/>
<div style="margin-bottom: 2em;">
    <h3>Wgrywanie obrazków</h3>
    <form action="<?php echo $this->generateUrl('photo', 'upload'); ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="title" id="title" placeholder="Tytul" required/>
        <?php if (!$isLogged): ?>
            <input type="text" name="author" id="author" placeholder="Autor" required/>
        <?php endif; ?>
        <br/>
        <input type="text" name="watermark" id="watermark" placeholder="Znak wodny" required/>
        <br/>
        <input type="file" name="file" id="file" required/>
        <br/>
        <?php if ($isLogged): ?>
            <label>Publiczne<input type="radio" name="public" id="author" value="true" checked="checked"/></label><br/>
            <label>Prywatne<input type="radio" name="public" id="author" value="false"/></label>
        <?php endif; ?>
        <br/>
        <input type="submit" value="Wrzuć" name="submit"/>
    </form>
</div>

<?php
if (!empty($error)) {
    echo "<span style='color:red''>" . htmlentities($error) . "</span>";
}
?>
<a class="btn" href="<?php echo $this->generateUrl('photo', 'finder'); ?>">Wyszukiwarka</a>     <a class="btn btn-success" href="<?php echo $this->generateUrl('photo', 'remembered') ?>">Zapamiętane</a>
<div class="images">
    <?php
    if (!empty($photos)) {
        ?>
        <form method="post" action="<?php echo $this->generateUrl('photo', 'remember'); ?>">
            <?php
            /** @var Photo $photo */
            foreach ($photos as $photo):
                ?>
                <div class="image"><a href=" <?php echo USR_IMG . $photo->watermarkName ?>"><img
                            src=" <?php echo USR_IMG . $photo->thumbnailName ?>"
                            title="<?php echo $photo->title ?>"/></a>
                    <br/>
                    <span><?php echo $photo->author ?></span>
                    <input type="checkbox" name="photo[]"
                           <?php if (in_array($photo->_id->{'$id'}, $rememberedPhotos)) { // if in the array of memorized by user, then check the checkbox
                               echo 'checked="true"';
                           } ?>value="<?php echo $photo->_id->{'$id'} ?>" title="Save Image"/>
                </div>
            <?php endforeach; ?>
            <input type="submit" value="Zapamiętaj Wybrane!"/>
        </form>
        <?php
    } else {
        echo "<h2>Brak zdjęć</h2>";
    }
    ?>
</div>

