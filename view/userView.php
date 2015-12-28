<?php

class userView extends View
{
    public function profile(User $user)
    {
        $this->set('title', 'Profil Użytkownika ' . $user->login);
        $content = $this->render('profile', false, '/templates/user');
        $this->set('user',$user);
        $this->set('content', $content);
        $this->render('default', true);
    }
}