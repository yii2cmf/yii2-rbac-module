<?php

use yii2cmf\modules\rbac\Module as M;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\AuthItem */
/* @var $modules array */
/* @var $type int */
/* @var $childRoles array */

$this->title = M::c('Creating Role');
$this->params['breadcrumbs'][] = ['label' => M::c('Roles'), 'url' => ['']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'allRoles' => $allRoles,
        'roles' => $roles,
        'childRoles1' => 0,
        'childParentRoleNames' => 0,
        'childParentRoleNames' => $childParentRoleNames
    ]) ?>

</div>