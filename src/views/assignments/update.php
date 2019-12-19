<?php

use yii\helpers\Html;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $model yii2cmf\modules\rbac\models\AuthAssignment */

$this->title = M::c('Update Assignment: {name}', [
    'name' => $model->item_name,
]);
$this->params['breadcrumbs'][] = ['label' => M::c('Auth Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_name, 'url' => ['view', 'item_name' => $model->item_name, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = M::c('Update');
?>
<div class="auth-assignment-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
