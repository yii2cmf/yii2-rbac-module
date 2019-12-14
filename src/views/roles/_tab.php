<?php
use yii\bootstrap\Html;
/* @var $container array */
/* @var $moduleName array */

?>

<div class="row">
    <?php foreach ($container as $controllerName => $i):?>
        <div class="col-md-12" style="padding-top: 10px">

            <div class="panel panel-primary">
                <div class="panel-heading"><?= $controllerName ?></div>
                <div class="panel-body">
                    <!-- \yii\bootstrap\Html::activeCheckboxList($model, 'actions[]', $i['actions'])?> -->
                    <?php foreach ($i['actions'] as $actionName => $value):?>
                        <div class="col-md-2">
                            <label class="checkbox-inline">
                                <?php $options = $value ? ['label' => $actionName,'checked' => 'checked'] : ['label' => $actionName]?>

                                <?= Html::activeCheckbox($model, "actions[$moduleName][$controllerName][$actionName]", $options) ?>
                            </label>
                        </div>

                    <?php endforeach;?>
                </div>
            </div>

        </div>

    <?php endforeach;?>
</div>
