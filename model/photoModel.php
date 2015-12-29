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

    public static function photoFromArray(array $data)
    {
        $photo = new Photo($data['original-url'], $data['thumbnail-url'], $data['watermark-url'], $data['title'], $data['author'], $data['_id'], $data['public']);
        $photo->ownerId = $data['owner-id'];
        return $photo;
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
     * @param User $owner
     * @return bool
     */
    public function add(Photo $photo, User $owner)
    {
        $photo->ownerId = $owner->id;
        $photos = $this->db->selectCollection('photos');
        $obj = self::photoToArray($photo);
        return $photos->insert($obj);
    }

    public static function photoToArray(Photo $photo)
    {
        return ['original-url' => $photo->originalUrl,
            'thumbnail-url' => $photo->thumbnailUrl,
            'watermark-url' => $photo->watermarkUrl,
            'owner-id' => (int)$photo->ownerId,
            'title' => $photo->title,
            'public' => $photo->isPublic(),
            'author' => $photo->author];
    }
}