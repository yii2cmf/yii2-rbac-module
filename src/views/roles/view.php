<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => M::c('Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(M::c('Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(M::c('Delete'), ['delete', 'id' => $model->name], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => M::m('Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'type',
                'value' => function ($data, $widget) {
                    return $data->type == 1 ? M::c('Role') : M::c('Permission');
                }
            ],
            'description:ntext',
            'rule_name',
            [
                'attribute' => 'created_at',
                'value' => function ($data, $widget) {
                    return Yii::$app->formatter->asDatetime(new DateTime(date('Y-m-d H:i', (int)$data->created_at)));
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($data, $widget) {
                    return Yii::$app->formatter->asDatetime(new DateTime(date('Y-m-d H:i', (int)$data->updated_at)));
                },
            ],
            //'data',
        ],
    ]) ?>

</div>
