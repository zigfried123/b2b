<?php

namespace models\services;

use models\entities\Item;
use models\traits\Singleton;

class ItemService
{
    use Singleton;

    const MAX_INDEX = 20;
    const BEGIN_PRICE = 100;
    const END_PRICE = 1000;

    public function generateItems()
    {
        $i = 0;

        while (++$i <= self::MAX_INDEX) {

            $item = new Item($i, "item$i", mt_rand(self::BEGIN_PRICE, self::END_PRICE));

            $items[] = $item;
        }

        return $items;

    }
}