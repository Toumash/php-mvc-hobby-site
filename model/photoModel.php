<?php

require_once ROOT . '/model/object/User.php';
require_once ROOT . '/model/object/Photo.php';
require_once ROOT . '/model/interface/PhotoModelInterface.php';
require_once ROOT . '/model/DatabaseModel.php';

class PhotoModel extends DatabaseModel implements PhotoModelInterface
{
    /**
     * @return Photo[]
     */
    public function getAllPublicPhotos()
    {
        $data = $this->db->selectCollection('photos');
        $data->find(['public' => true]);
    }

    /**
     * @param User $user
     * @return Photo[]
     */
    public function getAllUserPhotos(User $user)
    {
        //TODO:logic
    }

    /**
     * @param Photo $photo
     * @param User $owner
     * @return bool
     */
    public function add(Photo $photo, User $owner)
    {
        $photo->ownerId = $owner->id;
        //TODO: logic
    }
}