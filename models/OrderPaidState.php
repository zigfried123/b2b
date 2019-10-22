<?php
namespace models;

use models\entities\Order;
use models\repositories\OrderItemRepository;
use models\repositories\OrderRepository;

class OrderPaidState
{
    public function handle($orderId, $priceFromRequest)
    {
        $orderRepository = OrderRepository::getInstance();

        $order = $orderRepository->getOrderById($orderId);

        $orderItemRepository = OrderItemRepository::getInstance();
        $totalPrice =  $orderItemRepository->getTotalPrice($orderId);


        if($order['status'] == Order::NEW_STATUS && $totalPrice == $priceFromRequest){

            $ch = curl_init('https://ya.ru');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

            $res = curl_exec($ch);

            $code = curl_getinfo($ch,CURLINFO_RESPONSE_CODE);

            curl_close($ch);

            if($code == 200) {
                $order = new Order();

                $order->id = $orderId;
                $order->status = Order::PAID_STATUS;

                $orderRepository->updateStatusOrder($order);

                return $order->id;
            }
        }

    }
}