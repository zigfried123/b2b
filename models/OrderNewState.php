<?php

namespace models;

use models\entities\Order;
use models\entities\OrderItem;
use models\repositories\OrderItemRepository;
use models\repositories\OrderRepository;

class OrderNewState
{
    public function handle($itemIds = [])
    {
        $order = new Order();

        $order->status = Order::NEW_STATUS;

        $repository = OrderRepository::getInstance();

        $order->id = $repository->getNextId();

        $repository->save($order);

        foreach ($itemIds as $itemId) {
            $repository = new OrderItemRepository();

            $model = new OrderItem();
            $model->order_id = $order->id;
            $model->item_id = $itemId;

            $repository->save($model);

        }

        return $order->id;
    }
}