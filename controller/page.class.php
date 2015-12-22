<?php

class pageController extends Controller
{
    public function index()
    {
        $pageName = $_GET['page'];
        if (empty($pageName)) {
            $pageName = 'intro';
        }
        /** @var pageView $view */
        $view = View::load('page');
        $view->page($pageName);
    }
}