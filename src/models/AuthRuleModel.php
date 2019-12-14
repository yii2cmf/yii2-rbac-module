<?php
namespace yii2cmf\modules\rbac\models;

use yii2cmf\modules\rbac\Module;
use yii\base\Exception;
use yii\base\Model;
use yii\rbac\DbManager;
use yii\rbac\Permission;

class AuthRuleModel extends Model
{
    public $module;
    public $controller;
    public $action;
    public $rule_name;

    private $dbManager;
    private $oldPermissionName;

    public function __construct(string $oldPermissionName = null, $config = [])
    {
        parent::__construct($config);
        $this->oldPermissionName = $oldPermissionName;
        $this->dbManager = \Yii::$container->get(DbManager::class);
    }

    public function rules()
    {
        return [
            [['module', 'controller', 'action', 'rule_name'], 'required'],
            [['module', 'controller', 'action', 'rule_name'], 'string', 'max' => 255],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::class, 'targetAttribute' => ['rule_name' => 'name']],
            //[['rule_name'], 'default', 'value' => null] on update
        ];
    }

    public function attributeLabels()
    {
        return [
            'rule_name' => Module::c( 'Rule Name'),
            'module' => Module::c('Module'),
            'controller' => Module::c('Controller'),
            'action' => Module::c('Action'),
        ];
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function save():bool
    {
        /**
         * @var $authManager DbManager
         */
        $authManager = $this->dbManager;

        $name = $this->module.'_'.$this->controller.'_'.$this->action;

        $existNewPerm = $authManager->getPermission($name);

        // Update exist permission
        if ($existNewPerm && !$this->oldPermissionName) {
            return $authManager->update($name, $this->createPermission($name, $this->rule_name));
        // Update old exist permission(remove rule_name) & Update exist permission(add rule_name)
        } elseif ($existNewPerm && $this->oldPermissionName) {
            $parts = explode('_', $this->oldPermissionName);
            $oldName = $parts[0].'_'.$parts[1].'_'.$parts[2];
            $authManager->update($oldName, $this->createPermission($oldName));
            return $authManager->update($name, $this->createPermission($name, $this->rule_name));

        } elseif (!$existNewPerm && !$this->oldPermissionName) {
            // Create new permission
            return $authManager->add($this->createPermission($name, $this->rule_name));

        } elseif (!$existNewPerm && $this->oldPermissionName) {
            // Rename old permission
            $parts = explode('_', $this->oldPermissionName);
            $oldName = $parts[0].'_'.$parts[1].'_'.$parts[2];

            return $authManager->update($oldName, $this->createPermission($name, $this->rule_name));
        }
        return false;
    }

    private function createPermission(string $name, string $ruleName = null)
    {
        $permission = $this->dbManager->createPermission($name);
        $permission->description = null;
        $permission->ruleName = $ruleName;
        $permission->type = 2;
        return $permission;
    }

}