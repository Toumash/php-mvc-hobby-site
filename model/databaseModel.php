<?php

require_once ROOT . '/model/Database.php';

abstract class DatabaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connectToDB();
    }
}