<?php

use yii2cmf\modules\rbac\Module as M;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $role string */

$this->title = M::c(Module::c('Add rule for "{role}"', ['role' => $model->role]));
$this->params['breadcrumbs'][] = ['label' => M::c('Roles'), 'url' => ['index', 'type' => 1]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roles-form">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'rule_name')->dropDownList($authRules, ['prompt' => '...']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(M::c('Save'), ['class' => 'btn btn-primary btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>