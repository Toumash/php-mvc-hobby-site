<?php

abstract class Controller
{
    public function redirect($url)
    {
        header("location: " . $url);
    }
    public function redirectTo($controller,$action){
        header("location: /?c=$controller&a=$action");
    }

    public abstract function index();
}