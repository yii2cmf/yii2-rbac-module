<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $model app\modules\auth\models\AuthItem */
/* @var $modules array */
/* @var $controllers array */
/* @var $actions array */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'module')->dropDownList($modules, [
                //'prompt' => '...',
                'onchange' => '
                    $.post("'.Url::toRoute(['load-controllers-actions']).'", {id: $(this).val()}, function(data){
                        data = JSON.parse(data);
                        console.log(data);
                        
                        $("#authrulemodel-controller").html(data.controllers);
                        $("#authrulemodel-action").html(data.actions);
                        
                    }).fail(function(response) {
                        alert(\'Error: \' + response.responseText);
                    });;'
            ]) ?>
            <?= $form->field($model, 'controller')->dropDownList($controllers, [
                //'prompt' => '...',
                'onchange' => '
                    $.post("'.Url::toRoute(['load-actions']).'", {module: $("#authrulemodel-module option:selected").val(),controller: $(this).val()}, function(data){
                    data = JSON.parse(data);
                    $("#authrulemodel-action").html(data.actions);
                });'
            ]) ?>
            <?= $form->field($model, 'action')->dropDownList($actions) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'rule_name')->dropDownList($authRules, ['prompt' => '...']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(M::c('Save'), ['class' => 'btn btn-success btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
