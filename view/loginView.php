<?php


class loginView extends View
{

    public function index($error)
    {
        $this->set('title', 'Zaloguj się');
        $this->set('error', $error);
        $content = $this->render('user/login', false);

        $this->set('content', $content);
        $this->render('default', true);
    }
}