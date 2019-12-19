<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $model yii2cmf\modules\rbac\models\AuthAssignment */

$this->title = $model->item_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('modules/rbac/common', 'Auth Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auth-assignment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('modules/rbac/common', 'Update'), ['update', 'item_name' => $model->item_name, 'user_id' => $model->user_id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('modules/rbac/common', 'Delete'), ['delete', 'item_name' => $model->item_name, 'user_id' => $model->user_id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => Yii::t('modules/rbac/common', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
               'attribute' => 'user_id',
               'label' => M::c('User Id')
            ],
            'item_name',
            [
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($model->created_at, 'short')
            ]
        ],
    ]) ?>

</div>
