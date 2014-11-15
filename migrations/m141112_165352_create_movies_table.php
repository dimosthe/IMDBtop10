<?php

use yii\db\Schema;
use yii\db\Migration;

class m141112_165352_create_movies_table extends Migration
{
    public function up()
    {
        $this->createTable('movies', [
            'id' => 'pk',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
        ]); 

    }

    public function down()
    {
        $this->dropTable('movies');
    }
}
