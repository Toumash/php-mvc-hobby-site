<?php
require_once ROOT . '/util/photo_utils.php';

class photoController extends Controller
{

    const uploadPath = "\\web\\images/";
    const MAX_FILE_SIZE = 1000000;
    const THUMBNAIL_WIDTH = 200;
    const THUMBNAIL_HEIGHT = 125;

    public function index()
    {
        /** @var photoModel $model */
        $model = Model::load('photo');
        $photos = $model->getAllPublicPhotos();

        /** @var photoView $view */
        $view = View::load('photo');
        $view->set('photo-upload-error', $this->getSessionError('photo-upload'));
        $view->gallery($photos);
        $this->clearError('photo-upload');
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

        /** @var photoView $view */
        $view = View::load('photo');
        $view->userPhotos($user, $photos);
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

        /** @var userModel $users */
        $users = Model::load('user');
        $usr = null;
        if (!$users->isLoggedIn()) {
            $usr = User::createAnonymous('anonim');
        } else {
            $usr = $users->getLoggedUser();
        }

        /** @var photoModel $photos */
        $photos = Model::load('photo');
        if (!$photos->add(new Photo($target_file, $thumbnailLocation, $watermarkedLocation, $usr, $title, $author))) {
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
    }
}