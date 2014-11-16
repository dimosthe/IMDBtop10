<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DateForm;
use app\models\Dates;
use app\models\DatesMovies;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays the top 10 movies on IMDB given a specific date 
     * @return mixed
     **/
    public function actionIndex()
    {
		$dateForm = new DateForm();	
		// if the user submited the form and sent the date properly
        if (($dateForm->load(Yii::$app->request->post())) && $dateForm->validate()) 
        {
            // check if the data are already stored in the cache
            if( \Yii::$app->cache->get($dateForm->date) !== false)
                $provider = \Yii::$app->cache->get($dateForm->date);
            // if not, then fetch from the database
            else
            {
                $date = $this->findDate($dateForm->date);

                $query = DatesMovies::find()
                        ->where(['date_id' => $date->id])
                        ->orderBy('rank')
                        ->with('movie')->all(); // allow eager loading
                
                $provider = new ArrayDataProvider([
                    'allModels'=>$query
                ]);
                
                // cache the data
                \Yii::$app->cache->set($dateForm->date, $provider, 60);     
            }

            return $this->render('index', [
                'dateForm' => $dateForm,
                'charts' => $provider,
            ]);
        }
    
        return $this->render('index', [
            'dateForm' => $dateForm
        ]);
    }

    /**
     * Displays contact information
     * @return string
     **/
    public function actionContact()
    {
        return $this->render('contact');
    }

    /**
     * Displays about information
     * @return string
     **/
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Finds the Date model based on its date field
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param date                      $date
     * @return app\models\Dates         the loaded model
     * @throws NotFoundHttpException    if the model cannot be found
     */
    protected function findDate($date)
    {
        $date =  date("Y-m-d", strtotime($date));
        $model = Dates::findOne(['date'=>$date]);

        if($model === null)
           throw new NotFoundHttpException('The requested date does not exist in the archive'); 

       return $model;
    }
}