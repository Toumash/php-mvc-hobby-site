<?php

class Photo
{
    public $url;

    /**
     * @var User
     */
    public $user;

    public $title;

    public function __construct($url, $user, $title)
    {
        $this->url = $url;
        $this->user = $user;
        $this->title = $title;
    }
}