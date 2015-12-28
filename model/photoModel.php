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
        return $data->find(['public' => true]);
    }

    /**
     * @param User $user
     * @return Photo[]
     */
    public function getAllUserPhotos(User $user)
    {
        $photos = $this->db->selectCollection('photos');
        $query = ['owner-id' => $user->id];
        $result = $photos->find($query);
        $results = array();
        foreach ($result as $item) {
            array_push($results, self::photoFromArray($item));
        }
        return $results;

        // PHP5.5
        /*foreach ($result as $item) {
            yield new Photo($item['original-url'],$item['thumbnail-url'],$item['watermark-url'],$item['title'],$item['author'],$item['_id'],$item['public']);
        }*/
    }

    public static function photoFromArray(array $data)
    {
        return new Photo($data['original-url'], $data['thumbnail-url'], $data['watermark-url'], $data['title'], $data['author'], $data['_id'], $data['public']);
    }

    /**
     * @param Photo $photo
     * @param User $owner
     * @return bool
     */
    public function add(Photo $photo, User $owner)
    {
        $photo->ownerId = $owner->id;
        $photos = $this->db->selectCollection('photos');
        $obj = self::photoToArray($photo);
        $photos->insert($obj);
    }

    public static function photoToArray(Photo $photo)
    {
        return ['original-url' => $photo->originalUrl,
            'thumbnail-url' => $photo->thumbnailUrl,
            'watermark-url' => $photo->watermarkUrl,
            'owner-id' => $photo->ownerId,
            'title' => $photo->title];
    }
}