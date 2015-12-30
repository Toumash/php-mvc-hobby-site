<?php

class Photo
{
    public $_id;
    public $originalName;
    public $thumbnailName;
    public $watermarkName;

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
        $this->originalName = $url;
        $this->thumbnailName = $thumbnailUrl;
        $this->watermarkName = $watermarkUrl;
        $this->title = $title;
        $this->author = $author;
        $this->_id = $_id;
        $this->public = $public;
        $this->owner = $owner;
        if ($owner != null) {
            $this->ownerId = $this->owner->_id;
            $this->author = $owner->login;
        }
    }

    public function isPublic()
    {
        return $this->public;
    }
}