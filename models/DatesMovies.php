<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dates_movies".
 *
 * @property integer $id
 * @property integer $date_id
 * @property integer $movie_id
 * @property integer $rank
 * @property string $was
 *
 * @property Movies $movie
 * @property Dates $date
 */
class DatesMovies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dates_movies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_id', 'movie_id', 'rank', 'was'], 'required'],
            [['date_id', 'movie_id', 'rank'], 'integer'],
            [['was'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_id' => 'Date ID',
            'movie_id' => 'Movie ID',
            'rank' => 'Rank',
            'was' => 'Was',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movies::className(), ['id' => 'movie_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDate()
    {
        return $this->hasOne(Dates::className(), ['id' => 'date_id']);
    }
}
