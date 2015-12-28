<?php


class loginView extends View
{

    public function index()
    {
        $this->set('title', 'Zaloguj się');
        $this->set('error', null);
        $content = $this->render('login', false, '/templates/user');

        $this->set('content', $content);
        $this->render('default', true);
    }

    public function error($error)
    {
        $this->set('title', 'Zaloguj się');
        $this->set('error', $error);
        $content = $this->render('login', false, '/templates/user');

        $this->set('content', $content);
        $this->render('default', true);
    }
}