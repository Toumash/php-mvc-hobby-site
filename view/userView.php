<?php

class userView extends View
{
    public function profile(User $user)
    {
        $this->set('title', 'Profil Użytkownika ' . $user->login);
        $this->set('user',$user);
        $content = $this->render('user/profile', false);
        
        $this->set('content', $content);
        $this->render('default', true);
    }
}