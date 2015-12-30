<?php
/** @var Photo[] $photos */
$photos = $this->get('photos');
$userName = $this->get('login');

?>


<h1>Prywatna galeria: <?php echo $userName ?></h1>

<div class="images">
    <?php
    if (!empty($photos)) {
        foreach ($photos as $photo) {
            ?>
            <div class="image"><a href=" <?php echo USR_IMG . $photo->watermarkName ?>"><img
                        src=" <?php echo USR_IMG . $photo->thumbnailName ?>"/><br/><span><?php echo $photo->title ?></span>
                    <?php if (!$photo->isPublic()): ?> <img class="image-noresize" src="/images/lock.png"
                                                            alt="locked(private)"> <?php endif; ?></a>
            </div>
            <?php
        }
    } else {
        echo "<h2>Brak zdjęć</h2>";
    }
    ?>
</div>