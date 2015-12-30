<?php


class photoView extends View
{

    /**
     * @param $user User
     * @param $photos Photo[]
     */
    public function userPhotos(User $user, $photos)
    {

        $this->set('login', $user->login);
        $this->set('photos', $photos);
        $this->set('title', 'Zdjęcia użytkownika ' . $user->login);
        $content = $this->render('photos/user_photos', false);

        $this->set('content', $content);
        $this->render('default', true);
    }

    public function gallery($isLogged, $photos, $rememberedPhotos, $error)
    {
        $this->set('photos', $photos);
        $this->set('remembered-photos', $rememberedPhotos);
        $this->set('logged', $isLogged);
        $this->set('photo-upload-error', $error);
        $this->set('title', 'Galeria zdjęć użyszkodników');
        $content = $this->render('photos/gallery', false);

        $this->set('content', $content);
        $this->render('default', true);
    }

    public function remembered($photos)
    {
        $this->set('photos', $photos);
        $this->set('title', 'Zdjęcia zapamiętane przez użytkownika');
        $content = $this->render('/photos/remembered', false);
        $this->set('content', $content);
        $this->render('default', true);
    }

    public function ajaxFind($photos)
    {
        $this->set('photos', $photos);
        $this->render('/photos/ajaxfind', true);
    }

    public function finder()
    {
        $this->set('title', 'Wyszukiwarka publicznych zdjęć');
        $content = $this->render('/photos/finder', false);
        $this->set('content', $content);
        $this->render('default', true);
    }
}