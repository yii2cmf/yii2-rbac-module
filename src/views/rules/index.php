<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\auth\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type string */

$this->title = M::c('Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a(M::c('Add'), ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search_rule', ['model' => $searchModel]);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'description',
                'value' => function ($model, $key, $index, $column) {
                   return \yii\helpers\StringHelper::truncateWords($model->description, 10,'...');
                }
            ],
            [
                'attribute' => 'rule_name',
                'headerOptions' => ['title' => M::c('Name of the rule associated with this item')],
                //'visible' => $type == 2
            ],
            ['class' => 'yii\grid\ActionColumn']
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
