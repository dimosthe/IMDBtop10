<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dates".
 *
 * @property integer $id
 * @property string $date
 *
 * @property DatesMovies[] $datesMovies
 */
class Dates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatesMovies()
    {
        return $this->hasMany(DatesMovies::className(), ['date_id' => 'id']);
    }
}
