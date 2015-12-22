<?php

abstract class Controller
{
    public function redirect($url)
    {
        header("location: " . $url);
    }

    public abstract function index();
}