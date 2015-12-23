<?php

require_once 'user.php';
require_once 'photo.php';
require_once 'database_model.php';

class photoModel extends databaseModel
{

    /**
     * @return Photo[]
     */
    public function getAllPublicPhotos()
    {
        // FIXME: data stub
        return array(new Photo('troll.png', 'troll.thumbnail.png', 'troll.watermark.png', new User(0, 'toumash', 'Tomasz Dluski'), 'Beautifull world ofr demacia','Paolo Coelho'));
    }

    /**
     * @param User $user
     * @return Photo[]
     */
    public function getAllUserPhotos(User $user)
    {
        // FIXME: data stub
        return array(new Photo('troll.png', 'troll.thumbnail.png', 'troll.watermark.png', $user, 'Beautifull world ofr demacia','Paolo Coelho'));
    }

    /**
     * @param Photo $photo
     * @return bool
     */
    public function add(Photo $photo)
    {
        if ($photo->owner == null) {
            $photo->owner = User::createAnonymous('Anonim');
        }
        return true;
        // FIXME: actual database operation
    }
}