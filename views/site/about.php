<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        The IMDB archive application maintaines a simple archive of the top 10 movies on IMDB. The archive is browsable by date
    </p>
</div>
