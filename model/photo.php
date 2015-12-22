<?php

class Photo
{
    public $originalUrl;
    public $thumbnailUrl;
    public $watermarkUrl;


    /**
     * @var User
     */
    public $user;

    public $title;

    public function __construct($url, $thumbnailUrl,$watermarkUrl,$user, $title)
    {
        $this->originalUrl = $url;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->watermarkUrl = $watermarkUrl;
        $this->user = $user;
        $this->title = $title;
    }
}