<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $type int */
/* @var childRoles array */

$script = <<< JS
$(function(){
    var allRoles = $allRoles
    var checkboxes = $("#rolemodel-childroles input:checkbox");
    
    checkboxes.change(function(e){
        var checkedRoleName = $(this).val();
        if ($(this).is(':checked')) {
            $.each(allRoles, function(parentRole, childRoles) {
                if (parentRole == checkedRoleName) {
                   for(let i = 0;i < childRoles.length; i++){
                       $("#rolemodel-childroles input:checkbox[value="+childRoles[i]+"]").prop('checked', true);
                       if (checkedRoleName != childRoles[i]) {
                           $("#rolemodel-childroles input:checkbox[value="+childRoles[i]+"]").prop('disabled', 'disabled');
                       }
                   }
                }
            });
            
        } else {
            $.each(allRoles, function(parentRole, childRoles) {
                if (parentRole == checkedRoleName) {
                   for(let i = 0;i < childRoles.length; i++){
                       if (checkedRoleName != childRoles[i]) {
                           $("#rolemodel-childroles input:checkbox[value="+childRoles[i]+"]").removeAttr('disabled').prop('checked', false);
                       }
                   }
                }
            });
        }
    });
    
    function init(){
        var path = window.location.pathname;
        var items = path.split("/");
        var action = items[items.length-1];

        // if is update action
        if (action == 'update') {
            var childRoles = $childRoles1;
            var childParentRoleNames = $childParentRoleNames;
            for (let i = 0; i < childRoles.length; i++) {
               for (let y = 0; y < childParentRoleNames.length; y++) {
                   if (childRoles[i] != childParentRoleNames[y]) {
                       $("#rolemodel-childroles input:checkbox[value="+childRoles[i]+"]").prop('disabled', 'disabled');
                   }
                   $("#rolemodel-childroles input:checkbox[value="+childParentRoleNames[y]+"]").removeAttr('disabled');
               }
            }
        }
    }
    init();
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>
<div class="rbac-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>
        </div>

        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'childroles')->checkboxList($roles,  ['separator'=>'<br>']) ?>
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
