<?php

use yii\db\Schema;
use yii\db\Migration;

class m141112_170211_create_dates_movies_table extends Migration
{
    public function up()
    {
        $this->createTable('dates_movies', [
            'id' => 'pk',
            'date_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'movie_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rank' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'rating' => Schema::TYPE_STRING . ' NOT NULL',
        ]); 
        
        $this->addForeignKey('fk_dates_dates_movies', 'dates_movies', 'date_id', 'dates', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_movies_dates_movies', 'dates_movies', 'movie_id', 'movies', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('dates_movies');
    }
}
