<?php

use yii2cmf\modules\rbac\Module as M;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $controllerName string */
/* @var $role string */
/* @var $containers array */
/* @var $tabs array */
/* @var $model \app\modules\rbac\models\ActionsForm */

$this->title = M::c('Update Permissions for "{roleName}"', ['roleName' => $role]);
$this->params['breadcrumbs'][] = ['label' => M::c('Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<<JS

$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
  localStorage.setItem('selectedTab', $(e.target).attr("href").substr(1));
});


var selectedTab = localStorage.getItem('selectedTab');
if (selectedTab) {
  $('#add-perm a[href="#'+selectedTab+'"]').tab('show');
}
JS;
$this->registerJs($script);

?>
<div class="default-add-perm">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin() ?>

    <ul class="nav nav-tabs" id="add-perm">
        <?php foreach($model->container as $moduleName => $container):?>
            <li <?= array_key_first($model->container) == $moduleName ?  'class="active"' : '' ?>>
                <a data-toggle="tab" href="#<?=strtolower($moduleName)?>"><?= $moduleName ?></a>
            </li>
        <?php endforeach;?>
    </ul>

    <div class="tab-content">
        <?php foreach($model->container as $moduleName => $container):?>
            <div id="<?=strtolower($moduleName)?>" class="tab-pane <?= array_key_first($model->container) == $moduleName ?  'active' : '' ?>">
                <?= $this->render('_tab', ['moduleName' => $moduleName, 'model' => $model, 'container' => $container]) ?>
            </div>
        <?php endforeach;?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(M::c('Save'), ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a(M::c('Cancel'), ['index'],['class' => 'btn btn-default btn-flat']) ?>
    </div>
    <?php ActiveForm::end()?>

</div>
