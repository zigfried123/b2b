<?php
namespace models;

class Mysql
{
    /** @var \PDO $db */
    public static $db;

    public static function connect($config)
    {
        extract($config);

        self::$db = new \PDO("mysql:host=$server;dbname=$database", $user, $password);

        self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}