<?php
namespace yii2cmf\modules\rbac\models;

use yii\rbac\Role;
use yii2cmf\modules\rbac\Module;
use yii\base\Exception;
use yii\base\Model;
use yii\rbac\DbManager;
use yii\base\InvalidConfigException;

class RoleModel extends Model
{
    public $oldRoleName;
    public $name;
    public $type;
    public $description;
    public $data;
    public $rule_name;
    public $childroles;

    private $authManager;

    public function __construct(DbManager $authManager, $config = [])
    {
        parent::__construct($config);
        $this->authManager = $authManager;
    }

    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::class, 'targetAttribute' => ['rule_name' => 'name']],
            // Custom
            [['childroles'], 'safe'],
            [['description', 'rule_name'], 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Module::c('Name'),
            'type' => Module::c('Type'),
            'description' => Module::c('Description'),
            'rule_name' => Module::c('Rule Name'),
            'childroles' => Module::c('Child Roles'),
        ];
    }

    /**
     * @param mixed $oldRoleName
     */
    public function setOldRoleName($oldRoleName): void
    {
        $this->oldRoleName = $oldRoleName;
        $this->fill();
    }

    protected function fill()
    {
        $role = $this->authManager->getRole($this->getParentRoleName());

        $this->name = $this->oldRoleName;
        $this->description = $role->description;
        $this->type = $role->type;
        $this->data = $role->data;
        $childRoles = $this->getRoles($this->oldRoleName);

        $r = [];
        $childs = [];
        $s = '';
        foreach ($childRoles as $key => $childRoleName) {
            if ($this->name != $childRoleName) {
                $roleChildRoles = $this->authManager->getChildRoles($childRoleName);

                foreach ($roleChildRoles as $name => $roleChildRole) {
                    if ($childRoleName == $name) {
                        $childs[] = $name;
                        $s .= $name.'__';
                    }
                }
                $f = substr($s, 0, strrpos($s,'__'));
                $r[$f] = $f;
                $r[$s] = $f;

                if (count($childRoles) == $key+1) {
                    $this->childroles[$f] = $f;
                }
            }
        }
    }

    private function getRoles(string $roleName)
    {
        $childRoles = $this->authManager->getChildRoles($roleName);
        $roles = [];
        foreach ($childRoles as $childRole) {
            if ($roleName != $childRole->name) {
                $roles[] = $childRole->name;
            }
        }
        return $roles;
    }

    /**
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function save():bool
    {
        $role = $this->createAndAddRole($this->name);
        if ($role instanceof Role) {
            $this->addChildRoles($role, is_array($this->childroles) ? $this->childroles : null);
            return true;
        }
        $this->addError('name', Module::e('Role "{id}" is already exist.', ['id' => $this->name]));
        return false;
    }

    public function update():bool
    {
        $connection = \Yii::$app->db;
        try{
            $authManager = $this->authManager;

            $this->updateRole($authManager);

            $this->updateChildRoles();
        } catch (InvalidConfigException $e) {
            return false;
        }
        return true;
    }


    /**
     * @param DbManager $authManager
     * @return bool
     * @throws \Exception
     */
    private function updateRole(DbManager $authManager): bool
    {
        $role = ($this->oldRoleName != $this->name) ? $authManager->createRole($this->name) : $authManager->getRole($this->oldRoleName);
        $role->description = !empty($this->description) ? $this->description : null;
        $role->ruleName = $this->rule_name;
        $role->data = null;
        $role->type = 1;

        return $authManager->update($this->oldRoleName, $role);
    }

    private function isRolesChecked()
    {
        return $this->childroles;
    }

    private function updateChildRoles(): bool
    {
        $this->removeAllChildrenRoles();
        if (!$this->isRolesChecked()) {
            return true;
        }

        foreach ($this->childroles as $childrole) {
            $newSubRole = $this->authManager->getRole($childrole);

            if ($newSubRole) {

                if (!$this->authManager->hasChild($this->authManager->getRole($this->getParentRoleName()), $this->authManager->getRole($childrole))) {
                    try{
                        $this->authManager->addChild($this->authManager->getRole($this->getParentRoleName()), $newSubRole);
                    } catch (Exception $e) {
                        \Yii::$app->session->addFlash('error', $e->getMessage());
                        return false;
                    }
                }
            }
        }
        return false;
    }

    private function removeAllChildrenRoles():bool
    {
        return $this->authManager->removeChildren($this->authManager->getRole($this->getParentRoleName()));
    }

    private function getParentRoleName():string
    {
        if (isset($this->name) && is_string($this->name) && strlen($this->name) > 0) {
            return $this->name == $this->oldRoleName ? $this->oldRoleName : $this->name;
        } else {
            return $this->oldRoleName;
        }

    }

    /**
     * @param Role $role
     * @param array $childroles
     * @throws Exception
     */
    private function addChildRoles(Role $role, ?array $childroles):void
    {
        $authManager = $this->authManager;

        if (is_array($childroles) && count($childroles) > 0) {

            // Add child roles if exist
            foreach ($childroles as $key => $childrole) {

                // Check role is exist or not
                $rbacRole = $authManager->getRole($childrole);

                if (!$rbacRole) {
                    $rbacRole = $authManager->createRole($childrole);
                }
                $authManager->addChild($role, $rbacRole);

            }
        }
    }

    private function createAndAddRole(string $roleName, string $description = null):?Role
    {
        $authManager = $this->authManager;
        // Check role is not exist
        if (!$authManager->getRole($roleName)) {
            // Create new role
            $role = $authManager->createRole($roleName);
            $role->description = $description;

            // Add in Db table auth_item with type 1
            $authManager->add($role);
            return $role;
        }

        return null;
    }
}