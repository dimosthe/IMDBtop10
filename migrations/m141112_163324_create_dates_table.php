<?php

use yii\db\Schema;
use yii\db\Migration;

class m141112_163324_create_dates_table extends Migration
{
    public function up()
    {
        $this->createTable('dates', [
            'id' => 'pk',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
        ]); 
    }

    public function down()
    {
        $this->dropTable('dates');
    }
}
