<?php
/** @var Photo[] $photos */
$photos = $this->get('photos');
if (!empty($photos)) {
    foreach ($photos as $photo): ?>
        <div><a href=" <?php echo USR_IMG . $photo->watermarkName ?>"><img
                    src=" <?php echo USR_IMG . $photo->thumbnailName ?>"
                    title="<?php echo $photo->title ?>"/></a>
            <span><?php echo $photo->author ?></span>
        </div>
    <?php endforeach;
} else {
    echo "Brak zdjęć";
}