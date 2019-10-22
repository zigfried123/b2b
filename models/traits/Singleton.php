<?php
namespace models\traits;

trait Singleton
{
    private static $_instance;

    public static function getInstance()
    {
        if(!(self::$_instance instanceof static)){
            self::$_instance = new static();
        }

        return self::$_instance;
    }
}