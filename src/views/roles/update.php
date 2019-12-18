<?php

use yii2cmf\modules\rbac\Module as M;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\AuthItem */
/* @var $modules array */
/* @var $type int */
/* @var $childRoles array */

$this->title = M::c('Update Role');
$this->params['breadcrumbs'][] = ['label' => M::c('Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'oldRoleName' => $oldRoleName,
        'model' => $model,
        'allRoles' => $allRoles,
        'roles' => $roles,
        'childRoles1' => $childRoles1,
        'childroles' => $childroles,
        'childParentRoleNames' => $childParentRoleNames
    ]) ?>

</div>