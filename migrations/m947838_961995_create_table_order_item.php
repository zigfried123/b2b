<?php

namespace migrations;

use models\Migration;

class m947838_961995_create_table_order_item extends Migration
{

    public function up()
    {
        return $this->createTable('order_item', ['id' => $this->getPrimaryKey('id'), 'order_id' => $this->getInt('order_id'), 'item_id' => $this->getInt('item_id')]);
    }

    public function down()
    {
        return $this->dropTable('order_item');
    }

}
    
    