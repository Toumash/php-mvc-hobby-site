<?php


class userController extends Controller
{

    public function init()
    {
    }

    public function index()
    {
        /** @var userModel $users */
        $users = Model::load('user');
        if(!$users->isLoggedIn()){

            return;
        }
        $usr = $users->getLoggedUser();
        /** @var userView $profileView */
        $profileView = View::load('user');
        $profileView->index($usr);
    }

    public function photos(){
        /** @var userModel $users */
        $users = Model::load('user');
        if(!$users->isLoggedIn()){
            $this->redirectTo('user','login');
        }
    }
}