<?php

class Photo
{
    /**
     * @var MongoId
     */
    public $_id;
    public $originalName;
    public $thumbnailName;
    public $watermarkName;

    /**
     * @var MongoId
     */
    public $ownerId;

    public $author;

    public $title;
    private $public;

    public function __construct($url, $thumbnailUrl, $watermarkUrl, $title, $author, $_id = null, $public = true, MongoId $ownerId = null)
    {
        $this->originalName = $url;
        $this->thumbnailName = $thumbnailUrl;
        $this->watermarkName = $watermarkUrl;
        $this->title = $title;
        $this->author = $author;
        $this->_id = $_id;
        $this->public = $public;
        $this->ownerId = $ownerId;
    }

    public
    function isPublic()
    {
        return $this->public;
    }
}