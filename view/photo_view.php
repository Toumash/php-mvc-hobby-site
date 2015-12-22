<?php


class photoView extends View
{

    /**
     * @param $user User
     * @param $photos Photo[]
     */
    public function userPhotos($user, $photos)
    {

        $this->set('user-name', $user->name);
        $this->set('photos', $photos);
        $content = $this->render('photos/user_photos', false);

        $this->set('content', $content);
        $this->render('default', true);
    }

    public function gallery($photos)
    {
        $this->set('photos', $photos);
        $this->set('title', 'Galeria zdjęć użyszkodników');
        $content = $this->render('photos/gallery', false);
        $this->set('content', $content);
        $this->render('default', true);
    }
}