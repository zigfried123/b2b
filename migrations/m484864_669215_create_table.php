<?php

namespace migrations;

use models\Migration;

class m484864_669215_create_table extends Migration
{

    public function up()
    {
        return $this->createTable('item', ['id' => $this->getPrimaryKey('id'), 'name' => $this->getVarChar('name', 20), 'price' => $this->getFloat('price')]);
    }

    public function down()
    {
        return $this->dropTable('item');
    }

}
    
    