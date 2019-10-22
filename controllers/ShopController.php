<?php
namespace controllers;

use models\repositories\ItemRepository;
use models\services\ItemService;
use models\services\OrderService;

class ShopController
{
    public function __construct()
    {
        $this->setBeginData();
    }

    public function getItems()
    {
        $repository = ItemRepository::getInstance();

        if($_SERVER["REQUEST_METHOD"] != 'GET'){
            return json_encode(['status'=>'error', 'code'=>403, 'message'=>'Forbidden']);
        }

        return json_encode(['status'=>'ok','response'=>$repository->getAll()]);
    }

    public function makeOrder()
    {
        if($_SERVER["REQUEST_METHOD"] != 'POST'){
            return json_encode(['status'=>'error', 'code'=>403, 'message'=>'Forbidden']);
        }

        $order = new OrderService();

        $orderId = $order->create(json_decode($_REQUEST['ids']));

        return $orderId;

    }

    public function payOrder()
    {
        if($_SERVER["REQUEST_METHOD"] != 'PUT'){
            return json_encode(['status'=>'error', 'code'=>403, 'message'=>'Forbidden']);
        }

        $order = new OrderService();

        $orderId = $_REQUEST['orderId'];
        $price = $_REQUEST['price'];

        $orderId = $order->pay($orderId, $price);


        return $orderId;

    }

    private function setBeginData()
    {
        $repository = ItemRepository::getInstance();

        if($repository->isCountNull()) {

            $items = (new ItemService())->generateItems();

            foreach ($items as $item) {
                $repository->save($item);
            }

        }
    }

}