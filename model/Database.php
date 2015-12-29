<?php


class Database
{
    const DEFAULT_DATABESE = 'wai';
    private static $db = null;

    public static function connectToDB($dbName = self::DEFAULT_DATABESE)
    {
        if (!class_exists('MongoClient', false)) {
            die('No MongoClient installed. Check your config');
        }
        if (self::$db == null) {
            try {
                $mongo = new MongoClient(
                    "mongodb://localhost:27017/",
                    [
                        'username' => 'wai_web',
                        'password' => 'w@i_w3b',
                        'db' => $dbName,
                    ]);
            } catch (MongoConnectionException $e) {
                echo $e->getMessage();
                exit;
            }
            self::$db = $mongo->selectDB($dbName);;
        }
        return self::$db;
    }
}