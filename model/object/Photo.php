<?php

class Photo
{
    public $_id;
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

    public function __construct($url, $thumbnailUrl, $watermarkUrl, $title, $author, $_id = null, $public = true, User $owner = null)
    {
        $this->originalUrl = $url;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->watermarkUrl = $watermarkUrl;
        $this->title = $title;
        $this->author = $author;
        $this->_id = $_id;
        $this->public = $public;
        $this->owner = $owner;
        $this->ownerId = $this->owner->id;
        $this->author = $owner->login;
    }

    public function isPublic()
    {
        return $this->public;
    }
}