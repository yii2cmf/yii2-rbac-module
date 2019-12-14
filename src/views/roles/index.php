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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open']), $url);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), $url);
                    },
                    'permissions' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-lock', 'title' => 'Add/Edit Permission']), ['permissions', 'role' => $model->name]);
                    },
                    'rule' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-list-alt', 'title' => 'Add/Edit Rule']), ['rule', 'role' => $model->name]);
                    }
                ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>