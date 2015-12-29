<?php

require_once ROOT . '/model/object/User.php';
require_once ROOT . '/model/object/Photo.php';
require_once ROOT . '/model/interface/PhotoModelInterface.php';

class StubPhotoModel implements PhotoModelInterface
{

    /**
     * @var Photo[]
     */
    private $photos;

    public function __construct()
    {
        $this->photos = [new Photo('troll.png', 'troll.thumbnail.png', 'troll.watermark.png', 'Beautifull world ofr demacia', 'Paolo Coelho')];
    }

    /**
     * @return Photo[]
     */
    function getAllPublicPhotos()
    {
        $publicPhotos = array();
        foreach ($this->photos as $photo) {
            if ($photo->isPublic()) {
                array_push($publicPhotos, $photo);
            }
        }
        return $publicPhotos;
    }

    /**
     * @param User $user
     * @return Photo[]
     */
    function getAllUserPhotos(User $user)
    {
        $userPhotos = array();
        /** @var Photo $photo */
        foreach ($this - $this->photos as $photo) {
            if ($photo->ownerId == $user->_id) {
                array_push($userPhotos, $photo);
            }
        }
        return $userPhotos;
    }

    /**
     * @param Photo $photo
     * @param User $owner
     * @return bool
     */
    function add(Photo $photo, User $owner)
    {
        array_push($photos, $photo);
    }
}