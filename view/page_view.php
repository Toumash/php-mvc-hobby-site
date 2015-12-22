<?php

class pageView extends View
{
    function __construct()
    {
        $this->set('title', 'DefaultTitle');
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