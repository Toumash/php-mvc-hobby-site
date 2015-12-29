<?php

require_once ROOT . '/model/object/User.php';
require_once ROOT . '/model/object/Photo.php';
require_once ROOT . '/model/interface/PhotoModelInterface.php';
require_once ROOT . '/model/DatabaseModel.php';

class PhotoModel extends DatabaseModel implements PhotoModelInterface
{
    public function getPublicPhotosWithTitle($title)
    {
        $collection = $this->db->selectCollection('photos');
        $data = $collection->find(['title' => new MongoRegex("/{$title}/i"), 'public' => true]);
        $results = array();
        foreach ($data as $item) {
            array_push($results, self::photoFromArray($item));
        }
        return $results;
    }

    public static function photoFromArray(array $data)
    {
        $photo = new Photo($data['original-url'], $data['thumbnail-url'], $data['watermark-url'], $data['title'], $data['author'], $data['_id'], (boolean)$data['public']);
        $photo->ownerId = $data['owner-id'];
        return $photo;
    }

    /**
     * @return Photo[]
     */
    public function getAllPublicPhotos()
    {
        $data = $this->db->selectCollection('photos');
        return $data->find(['public' => true]);
    }

    public function getPhoto($id)
    {
        $photos = $this->db->selectCollection('photos');
        $result = $photos->find(['_id' => new MongoId($id)]);

        if ($result->hasNext()) {
            return self::photoFromArray($result->getNext());
        } else {
            return null;
        }
    }

    public function getPhotos(array $ids)
    {
        $photos = $this->db->selectCollection('photos');
        $mongoIds = array();
        foreach ($ids as $id) {
            $mongoIds[] = new MongoId($id);
        }
        $result = $photos->find(['_id' => ['$in' => $mongoIds]]);
        $results = array();
        foreach ($result as $item) {
            array_push($results, self::photoFromArray($item));
        }
        return $results;
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

    public function exists($id)
    {
        $photos = $this->db->selectCollection('photos');
        return $photos->findOne(['_id' => new MongoId($id)]) ? true : false;
    }

    /**
     * @param Photo $photo
     * @return bool
     */
    public function add(Photo $photo)
    {
        $photos = $this->db->selectCollection('photos');
        $obj = self::photoToArray($photo);
        return $photos->insert($obj);
    }

    public static function photoToArray(Photo $photo)
    {
        return ['original-url' => (string)$photo->originalUrl,
            'thumbnail-url' => (string)$photo->thumbnailUrl,
            'watermark-url' => (string)$photo->watermarkUrl,
            'owner-id' => (int)$photo->ownerId,
            'title' => (string)$photo->title,
            'public' => (boolean)$photo->isPublic(),
            'author' => (string)$photo->author];
    }
}