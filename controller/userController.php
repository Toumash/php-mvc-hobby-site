<?php


class userController extends controller
{
    /**
     * @var userModel
     */
    private $userModel;

    public function init()
    {
        $this->userModel = Model::load('user');
    }

    public function index()
    {
        if (!$this->userModel->isLoggedIn()) {
            $this->redirectTo('authorization', 'login_form');
            return;
        }
        $usr = $this->userModel->getLoggedUser();
        /** @var userView $profileView */
        $profileView = View::load('user');
        $profileView->profile($usr);
    }

    public function photos()
    {
        if (!$this->userModel->isLoggedIn()) {
            $this->redirectTo('authorization', 'login_form');
        }
        /** @var photoModel $photoModel */
        $photoModel = Model::load('photo');
        $usr = $this->userModel->getLoggedUser();
        $photos = $photoModel->getAllUserPhotos($usr);
        /** @var photoView $photoView */
        $photoView = View::load('photo');
        $photoView->userPhotos($usr, $photos);
    }
}