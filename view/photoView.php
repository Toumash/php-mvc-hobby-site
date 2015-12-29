<?php


class photoView extends View
{

    /**
     * @param $user User
     * @param $photos Photo[]
     */
    public function userPhotos($user, $photos)
    {

        $this->set('user-name', $user->login);
        $this->set('photos', $photos);
        $content = $this->render('photos/user_photos', false);

        $this->set('content', $content);
        $this->render('default', true);
    }

    public function gallery($photos, $error)
    {
        $this->set('photos', $photos);
        $this->set('photo-upload-error', $error);
        $this->set('title', 'Galeria zdjęć użyszkodników');
        $content = $this->render('gallery', false, '/templates/photos/');

        $this->set('content', $content);
        $this->render('default', true);
    }

    public function remembered($photos)
    {
        $this->set('photos', $photos);
        $this->set('title', 'Zdjęcia zapamiętane przez użytkownika');
        $content = $this->render('remembered', false, '/templates/photos/');
        $this->set('content', $content);
        $this->render('default', true);
    }
}