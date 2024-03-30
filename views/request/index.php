<?php

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Страница заявлений';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Оставить новое заявление', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>


    <?php
    foreach ($dataProvider->models as $model){

        $classCard = match ($model->status->code) {
            'approve' => 'text-white bg-success-card',
            'rejected' => 'text-white bg-danger-card',
            'new' => 'bg-light',
        }

        ?>
        <div class="card mb-2 <?= $classCard ?>" >
            <div class="card-body">
                <h5 class="card-title"><?= $model->auto_number ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $model->status->name ?></h6>
                <p class="card-text"><?= $model->text ?></p>
            </div>
        </div>
    <?php }

    echo LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);

    ?>


</div>
