<?php

namespace models\services;

use models\Mysql;
use models\OrderNewState;
use models\OrderPaidState;

class OrderService
{
    public function create($itemIds = [])
    {
        try {
            Mysql::$db->beginTransaction();

            $orderId = (new OrderNewState())->handle($itemIds);

            Mysql::$db->commit();

            return $orderId;

        } catch (\Exception $e) {
            var_dump($e);

            Mysql::$db->rollback();
        }

    }

    public function pay($orderId, $price)
    {
        return (new OrderPaidState())->handle($orderId, $price);
    }
}