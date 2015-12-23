<?php

class Photo
{
    public $originalUrl;
    public $thumbnailUrl;
    public $watermarkUrl;


    /**
     * @var User
     */
    public $owner;

    public $author;

    public $title;

    public function __construct($url, $thumbnailUrl,$watermarkUrl,$user, $title,$author)
    {
        $this->originalUrl = $url;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->watermarkUrl = $watermarkUrl;
        $this->owner = $user;
        $this->title = $title;
        $this->author = $author;
    }
}