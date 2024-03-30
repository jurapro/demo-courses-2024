<?php

use app\models\Request;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Панель администратора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    foreach ($dataProvider->models as $model){

        $classCard = match ($model->status->code) {
            'approve' => 'text-white bg-success-card',
            'rejected' => 'text-white bg-danger-card',
            'new' => 'bg-light'
        }

        ?>
        <div class="card mb-2 <?= $classCard ?>" >
            <div class="card-body">
                <h5 class="card-title"><?= $model->auto_number ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $model->status->name ?></h6>
                <h6 class="card-subtitle mb-2 text-muted"><?= $model->user->getFullName() ?></h6>
                <p class="card-text"><?= $model->text ?></p>

                <?php if ($model->status->code=='new') {
                    echo Html::a('Подтвердить', ['admin/success', 'id' => $model->id], ['class' => 'card-link']);
                    echo Html::a('Отклонить', ['admin/cancel', 'id' => $model->id], ['class' => 'card-link']);
                } ?>
            </div>
        </div>
    <?php }

    echo LinkPager::widget([
        'pagination' => $dataProvider->pagination,
    ]);

    ?>

</div>
