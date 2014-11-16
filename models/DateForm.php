<?php
namespace app\models;
use Yii;
use yii\base\Model;

/**
 * 
 * @author George Dimosthenous
 */
class DateForm extends Model
{
	public $date;

	/**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
			['date', 'required'],
		];
	}

	/**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
        ];
    }

    public function getDates()
    {
    	$dates = Dates::find()->all();

    	return $dates;
    }
}

?>