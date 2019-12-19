<?php

use yii\helpers\Html;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $model yii2cmf\modules\rbac\models\AuthAssignment */

$this->title = M::c('Assign role');
$this->params['breadcrumbs'][] = ['label' => M::c( 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
