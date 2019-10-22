<?php
namespace models\repositories;

use models\entities\Order;
use models\Mysql;

class OrderRepository extends EntityRepository
{
    public function getOrderById($id)
    {
        $q = Mysql::$db->prepare("SELECT * FROM `{$this->tableName}` WHERE id=:id");
        $q->execute(['id'=>$id]);

        return $q->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateStatusOrder(Order $order)
    {
        $q = Mysql::$db->prepare("UPDATE `{$this->tableName}` SET status=:status WHERE id=:id");
        $q->execute((array)$order);
    }

}