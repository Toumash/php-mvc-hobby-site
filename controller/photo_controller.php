<?php

require_once ROOT . '/util/photo_utils.php';

class photoController extends Controller
{

    const uploadPath = "\\web\\images/";
    const MAX_FILE_SIZE = 1000000;

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

        /** @var photoView $view */
        $view = View::load('photo');
        $view->userPhotos($user, $photos);
    }

    public function upload()
    {
        $error = null;
        $target_file = '';

        $file = $_FILES['file'];
        $text = $_POST['watermark'];
        if (!isset($_POST['submit'])) {
            $error = "Brak wysłanych danych";
        } elseif (!isset($_POST['watermark'])) {
            $error = "Brak znaku wodnego";
        } else {
            $target_file = ROOT . self::uploadPath . basename($file["name"]);

            if ($file["size"] > self::MAX_FILE_SIZE) {
                $error = "Zdjecie przekracza dopuszczalny rozmiar";
            }
            $validTypes = array('image/png', 'image/jpeg', 'image/jpg');
            $mime = PhotoUtils::getMimeType($file['tmp_name']);
            if (!in_array($mime, $validTypes)) {
                $error = 'Niedozwolone rozszerzenie. Lista poprawnych: ' . join(',', $validTypes);
            }
        }

        if ($error == null) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $name = substr($target_file, 0, strlen($target_file) - 4);
                $extension = substr($target_file, strlen($target_file - 4));
                PhotoUtils::watermark($target_file, $name . 'thumbnail' . $extension, $text, 14);
                /** @var userModel $users */
                $users = Model::load('user');
                $usr = $users->getLoggedUser();

                /** @var photoModel $model */
                $photos = Model::load('photo');
                if (!$photos->add($file['name'], $target_file, $usr)) {
                    $this->responseCode(500);
                    echo '500 Internal Server Error';
                    exit;
                } else {
                    $this->redirectTo('photo', 'index');
                    echo 'OK, przekierowuję....';
                }
            } else {
                $this->responseCode(500);
                echo "500 Internal Server Error";
            }
        } else {
            $this->redirectTo('photo', 'index', array('error' => $error));
        }
    }
}