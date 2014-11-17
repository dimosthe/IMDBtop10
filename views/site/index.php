<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
/* @var $this yii\web\View */
$this->title = 'IMDB top ten movies';
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>IMDB top ten movies archive</h1>

        <p class="lead">Displays the top ten movies for a specific date.</p>


    </div>
 <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'date-form']); ?>
                
                <?= $form->field($dateForm, 'date')->dropDownList(ArrayHelper::map($dateForm->getDates(), 'date', 'date'))  ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php if(isset($charts)){
    
        echo GridView::widget([
            'dataProvider' => $charts,
            'columns' => [
                'rank',
                [
                    'attribute'=>'movie_id',
                    'label'=>'title',
                    'value'=>'movie.title'
                ],
                'was'

            ]
            ]);
}   
?>