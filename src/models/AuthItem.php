<?php

namespace yii2cmf\modules\rbac\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii2cmf\modules\rbac\Module;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{
    public $module;
    public $controller;
    public $action;
    public $childroles;

    public const TYPE_ROLE = 1;
    public const TYPE_PERM = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::class, 'targetAttribute' => ['rule_name' => 'name']],
            // Custom
            [['module', 'controller', 'action', 'childroles'], 'safe'],
            [['description', 'rule_name'], 'default', 'value' => null],
        ];
    }

    /**
     * FIXME
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        if (Yii::$app->hasModule('rbac')) {
            return [
                'name' => Module::c('Name'),
                'type' => Module::c('Type'),
                'description' => Module::c('Description'),
                'rule_name' => Module::c('Rule Name'),
                'created_at' => Module::c('Created At'),
                'updated_at' => Module::c('Updated At'),
                'module' => Module::c('Module'),
                'controller' => Module::c('Controller'),
                'action' => Module::c('Action'),
                'childroles' => Module::c('Child Roles'),
            ];
        } else {
            return [
                'name' => Yii::t('app', 'Name'),
                'type' => Yii::t('app', 'Type'),
                'description' => Yii::t('app', 'Description'),
                'rule_name' => Yii::t('app', 'Rule Name'),
                'created_at' => Yii::t('app', 'Created At'),
                'updated_at' => Yii::t('app', 'Updated At'),
                'module' => Yii::t('app', 'Module'),
                'controller' => Yii::t('app', 'Controller'),
                'action' => Yii::t('app', 'Action'),
                'childroles' => Module::c('Child Roles'),
            ];
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                //'value' => new Expression('NOW()'),
                'value' => date('U'),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::class, ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::class, ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::class, ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'child'])
            ->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'parent'])
            ->viaTable('auth_item_child', ['child' => 'name']);
    }
}
