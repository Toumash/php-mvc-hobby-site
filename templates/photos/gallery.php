<div style="margin-bottom: 2em;">
    <form action="?c=photo&a=upload" method="post" enctype="multipart/form-data">
    <input type="text" name="title" id="title" placeholder="Tytul" required/>
    <input type="text" name="author" id="author" placeholder="Autor" required/>
    <br/>
    <input type="text" name="watermark" id="watermark" placeholder="Znak wodny" required/>
    <input type="file" name="file" id="file" required/>
    <input type="submit" value="Wrzuć" name="submit"/>
</form>
</div>

<?php
if(isset($_GET['error'])){
    echo htmlentities($_GET['error']);
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