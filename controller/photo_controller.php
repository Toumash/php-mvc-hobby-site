<?php

class photoController extends Controller
{

    public function index()
    {
        /** @var photoModel $model */
        $model = Model::load('photo');
        $photos = $model->getAllPublicPhotos();

        /** @var photoView $view */
        $view = View::load('photo');
        $view->gallery($photos);
    }

    public function userPhotos()
    {
        /** @var userModel $userModel */
        $userModel = Model::load('user');
        if (!$userModel->isLoggedIn()) {
            $this->redirectTo('photo', 'index');
            return;
        }

        $user = $userModel->getLoggedUser();
        /** @var photoModel $photoModel */
        $photoModel = Model::load('photo');
        $photos = $photoModel->getAllUserPhotos($user);

        /** @var galleryView $view */
        $view = View::load('gallery');
        $view->userPhotos($user,$photos);
    }
}