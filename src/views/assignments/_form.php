<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii2cmf\modules\rbac\models\User;
use yii2cmf\modules\rbac\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model yii2cmf\modules\rbac\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'item_name')->dropDownList(ArrayHelper::map(AuthItem::find()->where(['type' => 1])->asArray()->all(),'name', 'name')) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username')) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('modules/rbac/common', 'Save'), ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(Yii::t('modules/rbac/common', 'Back'), ['index'], ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
