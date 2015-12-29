<?php

class registrationView extends View
{
    public function index($error)
    {
        $this->set('title', 'Rejestracja');
        $this->set('error', $error);
        $content = $this->render('user/registration', false);

        $this->set('content', $content);
        $this->render('default', true);
    }
}