<?php

namespace migrations;

use models\Migration;

class m398057_955243_create_table_order extends Migration
{
    public function up()
    {
        return $this->createTable('order', ['id' => $this->getPrimaryKey('id'), 'status' => $this->getTinyInt('status')]);
    }

    public function down()
    {
        return $this->dropTable('order');
    }

}
    
    