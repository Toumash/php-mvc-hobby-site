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
        return array(new Photo('troll.png', 'toumash', 'Beautifull world of demacia'));
    }

    /**
     * @param User $user
     * @return Photo[]
     */
    public function getAllUserPhotos(User $user)
    {
        // FIXME: data stub
        return array(new Photo('troll.png', 'toumash', 'Beautifull world ofr demacia'));
    }

    public function add($name, $path, $user)
    {
        if ($user == null) {
            $user = new User(-1, 'anon', 'Niezalogowany');
        }
        // FIXME: actual database operation
    }
}