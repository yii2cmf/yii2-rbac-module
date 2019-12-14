<?php

use yii2cmf\modules\rbac\Module as M;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItem */
/* @var $modules array */
/* @var $controllers array */
/* @var $actions array */
/* @var $module string */
/* @var $controller string */
/* @var $action string */

$this->title = M::c('Add Rule');
$this->params['breadcrumbs'][] = ['label' => M::c('Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'modules' => $modules,
        'authRules' => $authRules,
        'controllers' => $controllers,
        'actions' => $actions
    ]) ?>

</div>
