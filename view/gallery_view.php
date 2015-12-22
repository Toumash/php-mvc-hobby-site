<?php

class galleryView extends View
{

    /**
     * @param $user User
     * @param $photos Photo[]
     */
    public function userPhotos($user, $photos)
    {
        $this->set('user-name', $user->name);
        $this->set('photos', $photos);
        $this->render('photos/user_photos');
    }
}