<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii2cmf\modules\rbac\models\User;
use yii2cmf\modules\rbac\Module as M;

/* @var $this yii\web\View */
/* @var $searchModel yii2cmf\modules\rbac\models\AuthAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * @var $authManager \yii\rbac\DbManager
 */

// TODO Refactor or move to helper
$authManager = $this->context->module->authManager;
foreach (array_keys($authManager->getRoles()) as $roleName) {
   $roleNames[$roleName] = $roleName;
}

$this->title = Yii::t('modules/rbac/common', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a(M::c('Add'), ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'user_id',
                'filter' => ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),
                'value' => function ($model, $key, $index, $column) {
                    //echo '<pre>';
                    //print_r($model->user->username);
                    //echo '</pre>';die;
                    return $model->user->username;
                }
            ],
            [
                'attribute' => 'item_name',
                'filter' => $roleNames
            ],
            [
                'attribute' => 'created_at',
                'filter' => false,
                'value' => function ($model, $key, $index, $column) {
                    return Yii::$app->formatter->asDate($model->created_at);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
