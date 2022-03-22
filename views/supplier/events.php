<?php

use app\models\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supplier Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>


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
        ],
    ]); ?>


</div>
