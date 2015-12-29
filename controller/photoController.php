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
        $view->gallery($photos, $this->getSessionError('photo-upload'));
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

        $this->redirectTo('photo', 'index');
    }

    public function show_remembered()
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
        $error = null;

        if (!isset($_POST)) {
            $error = "Brak wysłanych danych";
        } else if (!isset($_FILES['file'], $_POST['watermark'], $_POST['author'], $_POST['title'])) {
            $error = "Nie wprowadzono wszystkich wymaganych danych";
        }
        $file = isset($_FILES['file']) ? $_FILES['file'] : null;
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $error = "Zdjecie przekracza dopuszczalny rozmiar";
        } else {
            $mime = PhotoUtils::getMimeType($file['tmp_name']);
            if (!in_array($mime, $validTypes)) {
                $error = 'Niedozwolone rozszerzenie. Lista poprawnych: ' . join(',', $validTypes);
            }
        }

        if ($error != null) {
            $this->redirectTo('photo', 'index');
            $this->setSessionError('photo-upload', $error);
            return;
        }

        $target_file = ROOT . self::uploadPath . basename($file["name"]);

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            $this->responseCode(500);
            echo "500 Internal Server Error";
            return;
        }

        $text = $_POST['watermark'];
        $author = $_POST['author'];
        $title = $_POST['title'];
        $name = substr($target_file, 0, strlen($target_file) - 4);
        $extension = substr($target_file, strlen($target_file - 4));

        $watermarkedLocation = $name . 'watermark' . $extension;
        $thumbnailLocation = $name . 'thumbnail' . $extension;

        if (!PhotoUtils::watermark($target_file, $watermarkedLocation, $text, 14)) {
            $error = "Nie mozna stworzyc znaku wodnego";
        }
        if (!PhotoUtils::createThumbnail($target_file, $thumbnailLocation, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT)) {
            $error = "Nie mozna stworzyc miniaturki";
        }

        /** @var stubUserModel $users */
        $users = Model::load('User');
        $usr = null;
        if (!$users->isLoggedIn()) {
            $usr = User::anonymous();
        } else {
            $usr = $users->getLoggedUser();
        }

        if (!$this->photoModel->add(new Photo($target_file, $thumbnailLocation, $watermarkedLocation, $title, $author), $usr)) {
            $error = "Nie mozna dodac zdjecia do bazy danych";
        }

        if ($error == null) {
            $this->redirectTo('photo', 'index');
            echo 'OK, przekierowuję....';
        } else {
            $this->responseCode(500);
            echo '500 Internal Server Error. Error code:' . $error;
        }
    }

    public function init()
    {
        $this->photoModel = Model::load('photo');
    }
}