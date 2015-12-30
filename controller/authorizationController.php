<?php


class authorizationController extends controller
{
    const REGISTRATION_ERROR = 'registration-error';
    const LOGIN_ERROR = 'login-error';
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
        if ($this->users->isLoggedIn()) {
            $this->redirectTo('user', 'profile');
            return;
        }
        /** @var loginView $loginView */
        $loginView = View::load('login');
        $err = $this->getSessionError(self::LOGIN_ERROR);
        $loginView->index($err);

        $this->clearError(self::LOGIN_ERROR);
    }

    public function login()
    {
        if (isset($_POST['login']) && isset($_POST['password'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            if ($this->users->logIn($login, $password)) {
                $this->redirectTo('user', 'index');
            } else {
                $this->setSessionError(self::LOGIN_ERROR, "Nieprawidłowy login i/lub hasło");
                $this->redirectTo('authorization', 'login_form');
            }
        } else {
            $this->redirectTo('authorization', 'login_form');
        }
    }

    public function logout()
    {
        $this->users->logOut();
        $this->redirectTo('authorization', 'login_form');
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
        $registerView->index($errors);
        $this->clearError(self::REGISTRATION_ERROR);
    }

    public function register()
    {
        if ($this->users->isLoggedIn()) {
            $this->redirectTo('user', 'profile');
            return;
        }
        try {
            if (!isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['password_repeat']) || !isset($_POST['email'])) {
                throw new ValidationException("Nie wprowadzono wszystkich danych");
            }
            $login = $_POST['login'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password_repeat'];
            $email = $_POST['email'];

            if (strlen($login) < 3) {
                throw new ValidationException("Wybrany login jest zbyt krótki");
            }
            if (strlen($password) < 4) {
                throw new ValidationException("Wybrane hasło jest za krótkie");
            }
            if ($password !== $password_repeat) {
                throw new ValidationException("Wprowadzone hasła różnią się");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException("Podany adres email jest nieprawidłowy");
            }
            if ($this->users->loginExists($login)) {
                throw new ValidationException("Podany login już istnieje");
            }
            if ($this->users->emailExists($email)) {
                throw new ValidationException("Podany email już istnieje");
            }
            if (!$this->users->register($login, $password, $email)) {
                throw new ValidationException("Błąd");
            }
            $this->redirectTo('authorization', 'login_form');
        } catch (ValidationException $e) {
            $this->setSessionError(self::REGISTRATION_ERROR, $e->getMessage());
            $this->redirectTo('authorization', 'register_form');
        }
    }

    public function index()
    {
        $this->responseCode(404);
    }
}