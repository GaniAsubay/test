<?php

use app\models\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'date_created',
            'goal',
            'price',
            [
                    'attribute' => 'supplier_id',
                'value' => function($data) {
                    return $data->supplier->endpoint;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getStatusName();
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{confirmed}{update}',
                'buttons' => [
                        'confirmed' => function ($url, $data) {
                            if ($data->status === Event::STATUS_CREATED) {
                                return Html::a('Подтвердить', [$data], [
                                    'class' => 'btn btn-success'
                                ]);
                            }
                        }
                ]
            ],
        ],
    ]); ?>


</div>
