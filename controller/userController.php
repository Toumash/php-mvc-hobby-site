<?php


class userController extends controller
{
    /**
     * @var userModel
     */
    private $userModel;

    public function init()
    {
    }

    public function index()
    {
        if (!$this->userModel->isLoggedIn()) {
            $this->redirectTo('authorization','login_form');
            return;
        }
        $usr = $this->userModel->getLoggedUser();
        /** @var userView $profileView */
        $profileView = View::load('user');
        $profileView->index($usr);
    }

    public function photos()
    {
        if (!$this->userModel->isLoggedIn()) {
            $this->redirectTo('user', 'login_form');
        }
    }
}