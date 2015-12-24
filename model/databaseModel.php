<?php

require_once ROOT . '/model/database.php';

abstract class DatabaseModel
{
    public $db;

    public function __construct()
    {
        $this->db = Database::connectToDB();
    }
}