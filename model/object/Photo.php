<?php

class Photo
{
    public $id;
    public $originalUrl;
    public $thumbnailUrl;
    public $watermarkUrl;

    /**
     * @var integer
     */
    public $ownerId;
    public $author;

    public $title;
    private $public;

    public function __construct($url, $thumbnailUrl, $watermarkUrl, $title, $author, $id = null, $public = true)
    {
        $this->originalUrl = $url;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->watermarkUrl = $watermarkUrl;
        $this->title = $title;
        $this->author = $author;
        $this->id = $id;
        $this->public = $public;
    }

    public function isPublic()
    {
        return $this->public;
    }

}