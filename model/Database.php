<?php


class Database
{
    const DEFAULT_DATABESE = 'wai';

    public static function connectToDB($dbName = self::DEFAULT_DATABESE)
    {
        if (!class_exists('MongoClient', false)) {
            die('No MongoClient installed. Check your config');
        }
        $mongo = new MongoClient(
            "mongodb://localhost:27017/",
            [
                'username' => 'wai_web',
                'password' => 'w@i_w3b',
                'db' => $dbName,
            ]);

        $db = $mongo->selectDB($dbName);;
        return $db;
    }
}