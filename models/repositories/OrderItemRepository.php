<?php

namespace models\repositories;

use models\Mysql;

class OrderItemRepository extends EntityRepository
{
    public function __construct()
    {
        parent::__construct();

        $this->tableName = 'order_item';
    }

    public function getTotalPrice($id)
    {
        $q = Mysql::$db->prepare("SELECT sum(price) as sum FROM `{$this->tableName}` as oi LEFT JOIN item as i ON oi.item_id=i.id GROUP BY oi.order_id HAVING oi.order_id=:id");
        $q->execute(['id' => $id]);

        $res = $q->fetch(\PDO::FETCH_ASSOC)['sum'];

        return $res;
    }

}