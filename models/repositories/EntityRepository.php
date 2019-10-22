<?php

namespace models\repositories;

use models\entities\Entity;
use models\Mysql;
use models\traits\Singleton;

class EntityRepository
{
    use Singleton;

    protected $tableName;

    public function __construct()
    {
        $className = end(explode('\\', get_called_class()));
        $classNameWithoutRepository = str_replace('Repository', '', $className);
        $this->tableName = strtolower($classNameWithoutRepository);
    }

    public function getAll()
    {
        $q = Mysql::$db->prepare("SELECT * FROM {$this->tableName}");

        $q->execute();

        $res = $q->fetchAll(\PDO::FETCH_ASSOC);

        return $res;
    }

    public function isCountNull()
    {
        $q = Mysql::$db->prepare("SELECT count(*) FROM {$this->tableName}");

        $q->execute();

        $count = +$q->fetch()['count(*)'];

        return $count == 0;
    }

    public function save(Entity $entity)
    {
        $entity = (array)$entity;

        $keys = implode(',', array_keys($entity));

        $vals = implode(',', array_map(function ($v) {
            return ":$v";
        }, array_keys($entity)));

        $sql = "INSERT INTO `{$this->tableName}` ($keys) VALUES ($vals)";

        $q = Mysql::$db->prepare($sql);

        $q->execute((array)$entity);
    }

    public function getNextId()
    {
        $q = Mysql::$db->prepare("SELECT id FROM `{$this->tableName}` ORDER BY id DESC");

        $q->execute();

        return $q->fetch()['id'] + 1;
    }

}