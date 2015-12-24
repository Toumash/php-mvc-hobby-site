<?php

class pageController extends controller
{
    public function index()
    {
        $pageName = isset($_GET['page']) ? $_GET['page'] : 'intro';

        /** @var pageView $view */
        $view = View::load('Page');
        $view->page($pageName);
    }

    public function init()
    {
    }
}