<?php

class pageView extends View
{
    private $menuItems = array();

    function __construct()
    {
        $this->menuItems = array(
            'Wstęp' => '?c=page&page=intro',
            'Podstawy C#' => '?c=page&page=tut',
            'Galeria' => '?c=photo',
            'Kontakt' => '?c=page&page=contact'
        );
        $this->set('title', 'DefaultTitle');
        $this->set('menuItems', $this->menuItems);
    }

    public function index($value)
    {
        $this->set('simpleValue', $value);

        $this->render('default');
    }

    public function page($name)
    {
        if (is_file(ROOT . '\pages/' . $name . '.html')) {
            $content = $this->renderPage($name, false);
            $this->set('content', $content);
            $this->render('default', true);
            return true;
        } else {
            return false;
        }
    }

    public function renderPage($name, $output = true, $path = '\pages/')
    {
        return $this->render($name, $output, $path, '.html');
    }

}