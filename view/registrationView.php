<?php

class registrationView extends View
{
    public function index()
    {
        $this->set('title', 'Rejestracja');
        $content = $this->render('user/registration', false);

        $this->set('content', $content);
        $this->render('default', true);
    }

    public function error($error)
    {
        $this->set('title', 'Rejestracja');
        $this->set('error', $error);
        $content = $this->render('user/registration', false);

        $this->set('content', $content);
        $this->render('default', true);
    }
}