<?php
/** @var Photo[] $photos */
$photos = $this->get('photos');
if (!empty($photos)) {
    foreach ($photos as $photo): ?>
        <div><a href=" <?php echo $photo->watermarkUrl ?>"><img src=" <?php echo $photo->thumbnailUrl ?>"
                                                                title="<?php echo $photo->title ?>"/></a>
            <span><?php echo $photo->author ?></span>
        </div>
    <?php endforeach;
} else {
    echo "Brak zdjęć";
}