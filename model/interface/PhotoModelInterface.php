<?php
require_once ROOT . '/model/object/User.php';
require_once ROOT . '/model/object/Photo.php';

interface PhotoModelInterface
{
    /**
     * @return Photo[]
     */
    function getAllPublicPhotos();

    /**
     * @param User $user
     * @return Photo[]
     */
    function getAllUserPhotos(User $user);

    /**
     * @param Photo $photo
     * @param User $owner
     * @return bool
     */
    function add(Photo $photo, User $owner);

    /**
     * @param $id string
     * @return bool
     */
    function exists($id);
}