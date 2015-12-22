<?php


class databaseModel extends Model
{
    private $mongo;
    private $db;

    function __construct()
    {
        if(!class_exists('MongoClient',false)){

        }
        $mongo = new MongoClient(
            "mongodb://localhost:27017/",
            [
                'username' => 'wai_web',
                'password' => 'w@i_w3b',
                'db' => 'wai',
            ]);

        $db = $mongo->wai;
        $this->mongo = $mongo;
        $this->db = $db;
    }
}