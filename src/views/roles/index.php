<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\auth\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $type string */

$this->title =  M::c('Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a(M::c('Add'), ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'description',
                'value' => function ($model, $key, $index, $column) {
                   return \yii\helpers\StringHelper::truncateWords($model->description, 10,'...');
                }
            ],
            [
                'label' => M::c('Child Roles'),
                'value' => function ($model, $key, $index, $column) {

                    /**
                     * @var $authManager \yii\rbac\DbManager
                     */
                    $authManager = $this->context->module->authManager;
                    $childRoleObjects = $authManager->getChildRoles($model->name);
                    $roles = '';
                    foreach ($childRoleObjects as $childRoleObject){
                        if ($childRoleObject->name != $model->name) {
                            $roles .= $childRoleObject->name.', ';
                        }
                    }
                    $roles = substr($roles, 0, strrpos($roles, ','));
                    return $roles;
                }
            ],
            [
                'attribute' => 'rule_name',
                'headerOptions' => ['title' => M::c('Name of the rule associated with this item')],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {rule} {permissions} {add-subroles} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open', 'style' => 'padding-right:4px']), $url);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil', 'style' => 'padding-right:4px']), $url);
                    },
                    'permissions' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-lock', 'title' => 'Update Permission', 'style' => 'padding-right:4px']), ['permissions', 'role' => $model->name]);
                    },
                    'rule' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-list-alt', 'title' => 'Add/Edit Rule', 'style' => 'padding-right:4px']), ['rule', 'role' => $model->name]);
                    }
                ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
