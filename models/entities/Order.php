<?php
namespace models\entities;

class Order extends Entity
{
    const NEW_STATUS = 1;
    const PAID_STATUS = 2;

    public $id;
    public $status;

}