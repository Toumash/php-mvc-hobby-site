<?php
require_once ROOT . '/util/photo_utils.php';

class photoController extends controller
{

    const uploadPath = "\\web\\images/";
    const MAX_FILE_SIZE = 1000000;
    const THUMBNAIL_WIDTH = 200;
    const THUMBNAIL_HEIGHT = 125;

    /**
     * @var photoModel
     */
    private $photoModel;


    public function index()
    {
        $photos = $this->photoModel->getAllPublicPhotos();

        /** @var photoView $view */
        $view = View::load('photo');
        /** @var userModel $userModel */
        $userModel = Model::load('user');

        $view->gallery($userModel->isLoggedIn(), $photos, $this->getSessionError('photo-upload'));
        $this->clearError('photo-upload');
    }

    public function userPhotos()
    {
        /** @var stubUserModel $userModel */
        $userModel = Model::load('user');
        if (!$userModel->isLoggedIn()) {
            $this->redirectTo('photo', 'index');
            return;
        }

        $user = $userModel->getLoggedUser();
        $photos = $this->photoModel->getAllUserPhotos($user);

        /** @var photoView $view */
        $view = View::load('photo');
        $view->userPhotos($user, $photos);
    }

    public function remember()
    {
        $toRemember = array();
        if (!empty($_POST) && isset($_POST['photo'])) {
            foreach ($_POST['photo'] as $photoId) {
                if ($this->photoModel->exists($photoId)) {
                    $toRemember[] = $photoId;
                }
            }
        }
        $_SESSION['photo']['session-list'] = $toRemember;
        $this->redirectTo('photo', 'index');
    }

    public function forget()
    {
        if (!empty($_POST) && isset($_POST['photo'])) {
            $remembered = array_diff($_SESSION['photo']['session-list'], $_POST['photo']);
            $_SESSION['photo']['session-list'] = $remembered;
        }
        $this->redirectTo('photo', 'remembered');
    }

    public function remembered()
    {
        $ids = $_SESSION['photo']['session-list'];
        $photos = $this->photoModel->getPhotos($ids);
        /** @var photoView $view */
        $view = View::load('photo');
        $view->remembered($photos);
    }

    public function upload()
    {
        $validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        // only user/ validation exceptions
        try {

            if (!isset($_POST)) {
                throw new ValidationException("Brak wysłanych danych");
            } else if (!isset($_FILES['file'], $_POST['watermark'], $_POST['author'], $_POST['title'])) {
                throw new ValidationException("Nie wprowadzono wszystkich wymaganych danych");
            }
            $file = isset($_FILES['file']) ? $_FILES['file'] : null;
            if ($file['size'] > self::MAX_FILE_SIZE) {
                throw new ValidationException("Zdjecie przekracza dopuszczalny rozmiar");
            } else {
                $mime = PhotoUtils::getMimeType($file['tmp_name']);
                if (!in_array($mime, $validTypes)) {
                    throw new ValidationException('Niedozwolone rozszerzenie. Lista poprawnych: ' . join(',', $validTypes));
                }
            }
        } catch (ValidationException $e) {
            $this->redirectTo('photo', 'index');
            $this->setSessionError('photo-upload', $e->getMessage());
            return;
        }

        // server exceptions
        try {
            $target_file = ROOT . self::uploadPath . basename($file["name"]);

            if (!move_uploaded_file($file["tmp_name"], $target_file)) {
                $this->responseCode(500);
                echo "500 Internal Server Error";
                return;
            }

            $text = $_POST['watermark'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $public = $_POST['public'] == 'true';
            $name = substr($target_file, 0, strlen($target_file) - 4);
            $extension = substr($target_file, strlen($target_file - 4));

            $watermarkedLocation = $name . 'watermark' . $extension;
            $thumbnailLocation = $name . 'thumbnail' . $extension;

            if (!PhotoUtils::watermark($target_file, $watermarkedLocation, $text, 14)) {
                throw new Exception("Nie mozna stworzyc znaku wodnego");
            }
            if (!PhotoUtils::createThumbnail($target_file, $thumbnailLocation, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT)) {
                throw new Exception("Nie mozna stworzyc miniaturki");
            }

            /** @var stubUserModel $users */
            $users = Model::load('User');
            $photo = null;
            if ($users->isLoggedIn()) {
                $usr = $users->getLoggedUser();
                $photo = new Photo($target_file, $thumbnailLocation, $watermarkedLocation, $title, $author, null, $public, $usr);
            } else {
                $photo = new Photo($target_file, $thumbnailLocation, $watermarkedLocation, $title, $author);
            }
            if (!$this->photoModel->add($photo)) {
                throw new Exception("Nie mozna dodac zdjecia do bazy danych");
            }

            $this->redirectTo('photo', 'index');
        } catch (Exception $e) {
            $this->responseCode(500);
            echo '500 Internal Server Error. Error code:' . $e->getMessage();
        }
    }
    public function finder(){
        /** @var photoView $view */
        $view = View::load('photo');
        $view->finder();
    }

    public function find_photos()
    {
        if (isset($_GET['title'])) {
            $title = $_GET['title'];
            $photos = $this->photoModel->getPublicPhotosWithTitle($title);
            /** @var photoView $view */
            $view = View::load('photo');
            $view->ajaxFind($photos);
        } else {
            echo "Brak zdjęć o podanym tytule";
        }
    }

    public function init()
    {
        $this->photoModel = Model::load('photo');
    }
}