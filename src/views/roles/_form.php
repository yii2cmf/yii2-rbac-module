<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $type int */
/* @var $childRoles array */

?>
<div class="rbac-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>
        </div>

        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'childroles')->checkboxList($childRoles,  ['separator'=>'<br>']) ?>
        </div>
    </div>
    <div class="row">

    </div>

    <div class="form-group">
        <?= Html::submitButton(M::c('Save'), ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(M::c('Cancel'), ['index'],['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
