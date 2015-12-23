<?php


class authorizationController extends Controller
{
    /**
     * @var userModel $users
     */
    private $users;

    public function init()
    {
        $this->users = Model::load('user');
    }

    public function login_form()
    {
        if($this->users->isLoggedIn()){
            $this->redirectTo('user','profile');
            return;
        }
        /** @var loginView $loginView */
        $loginView = View::load('login');
        $loginView->index();
    }

    public function register_form(){
        if($this->users->isLoggedIn()){
            $this->redirectTo('user','profile');
            return;
        }
        /** @var registerView $registerView */
        $registerView = View::load('register');
        $registerView->index();
    }

    public function register(){
        if($this->users->isLoggedIn()){
            $this->redirectTo('user','profile');
            return;
        }
        // TODO: registration logic
        $login =null;
        $password = null;
        $password_repeat = null;
        $email = null;

        $error = null;
        if($this->users->loginExists($login)){
            $error = "Login already exists";
        }
        if($error == null) {
            $this->users->register($login, $password, $email);
            $this->redirectTo('authorization','confirmation');
        }
    }

    public function index()
    {
        $this->responseCode(404);
    }
}