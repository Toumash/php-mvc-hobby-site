<?php

class photoController extends Controller
{

    const uploadPath = "\\web\\images/";

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
        if (!isset($_POST['submit'])) {
            $error = "Brak wysłanych danych";
        } else {
            $target_file = ROOT . self::uploadPath . basename($_FILES['file']["name"]);

            if ($_FILES["file"]["size"] > 1000000) {
                $error = "Zdjecie przekracza dopuszczalny rozmiar";
            }
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_name = $_FILES['file']['tmp_name'];
            $mime_type = finfo_file($finfo, $file_name);
            $validTypes = array('image/png', 'image/jpeg', 'image/gif', 'image/jpg');
            if (!in_array($mime_type, $validTypes)) {
                $error = 'Niedozwolone rozszerzenie. Lista poprawnych: ' . join(',', $validTypes);
            }
        }

        if ($error != null) {
            $this->redirectTo('photo', 'index', array('error' => $error));
        } else {
            if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
                $this->redirectTo('photo','index');
                echo 'OK, przekierowuję....';
            } else {
                $this->responseCode(500);
                $this->redirectTo('photo','index',array());
                echo "Internal Server Error";
            }
        }
    }
}