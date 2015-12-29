<?php


class authorizationController extends controller
{
    const REGISTRATION_ERROR = 'registration-error';
    /**
     * @var stubUserModel $users
     */
    private $users;

    public function init()
    {
        $this->users = Model::load('user');
    }

    public function login_form()
    {
        if ($this->users->isLoggedIn()) {
            $this->redirectTo('user', 'profile');
            return;
        }
        /** @var loginView $loginView */
        $loginView = View::load('login');
        $err = $this->getSessionError('login-error');
        if($err != null) {
            $loginView->error($err);
        }else{
            $loginView->index();
        }
    }

    public function register_form()
    {
        if ($this->users->isLoggedIn()) {
            $this->redirectTo('user', 'profile');
            return;
        }
        $errors = $this->getSessionError(self::REGISTRATION_ERROR);
        /** @var registrationView $registerView */
        $registerView = View::load('registration');
        if($errors != null){
            $registerView->error($errors);
        }else{
            $registerView->index();
        }
    }

    public function register()
    {
        if ($this->users->isLoggedIn()) {
            $this->redirectTo('user', 'profile');
            return;
        }
        try {
            if (!isset($_POST['login'], $_POST['password'], $_POST['passoword_repeat'], $_POST['email'])) {
                throw new ValidationException("Nie wprowadzono wszystkich danych");
            }
            $login = $_POST['login'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password_reapeat'];
            $email = $_POST['email'];

            if (strlen($login) < 3) {
                throw new ValidationException("Wybrany login jest zbyt krótki");
            }
            if (!strcmp($password, $password_repeat) === 0) {
                throw new ValidationException("Wprowadzone hasła różnią się");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException("Podany adres email jest nieprawidłowy");
            }
            if ($this->users->loginExists($login)) {
                throw new ValidationException("Login already exists");
            }

            $this->users->register($login, $password, $email);
            $this->redirectTo('authorization', 'confirmation');
        } catch (ValidationException $e) {
            $this->setSessionError(self::REGISTRATION_ERROR, $e->getMessage());
            $this->redirectTo('authorization', 'register_form');
        }
    }

    public function index()
    {
        $this->responseCode(404);
    }

    public function confirmation()
    {

    }
}