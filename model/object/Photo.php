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
    /**
     * @var User
     */
    public $owner;
    public $author;

    public $title;
    private $public;

    public function __construct($url, $thumbnailUrl, $watermarkUrl, $title, $author, $id = null, $public = true, User $owner = null)
    {
        $this->originalUrl = $url;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->watermarkUrl = $watermarkUrl;
        $this->title = $title;
        $this->author = $author;
        $this->id = $id;
        $this->public = $public;
        $this->owner = $owner;
        $this->ownerId = $this->owner->id;
    }

    public function isPublic()
    {
        return $this->public;
    }

}