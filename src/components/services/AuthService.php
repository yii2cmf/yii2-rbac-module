<?php
namespace yii2cmf\modules\rbac\components\services;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;
use yii\rbac\Role;
use yii2cmf\modules\rbac\models\AuthItem;
use yii2cmf\modules\rbac\models\AuthItemChild;
use phpDocumentor\Reflection\Types\Boolean;
use yii2cmf\modules\rbac\models\AuthRule;


class AuthService extends Component
{
    /**
     * @var $dbManager DbManager
     */
    private $dbManager;


    public function __construct(DbManager $dbManager, $config = [])
    {
        parent::__construct($config);
        $this->dbManager = $dbManager;
    }

    public function getAuthRules()
    {
        return ArrayHelper::map(AuthRule::find()->all(), 'name', 'name');
    }

    /**
     * @param string $roleName
     * @param string|null $description
     * @return Role|null
     * @throws \Exception
     */
    public function createAndAddRole(string $roleName, string $description = null):?Role
    {
        $authManager = $this->dbManager;
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

    public function updateRole(string $roleOldName, string $roleNewName, string $description = null):?Role
    {
        $authManager = $this->dbManager;

        /**
         * @var $role Role
         */
        $role = $authManager->getRole($roleOldName);
        $role->name = $roleNewName;
        $role->description = $description;
        $authManager->update($roleOldName, $role);
        return $role;
    }

    /**
     * @param Role $role
     * @param array $childroles
     * @throws Exception
     */
    public function addChildRoles(Role $role, ?array $childroles):void
    {
        $authManager = $this->dbManager;

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

    /**
     * @param Role $role
     * @param array $childroles
     * @throws Exception
     */
    public function updateChildRoles(Role $role, ?array $childroles):void
    {
        $authManager = $this->dbManager;

        // Remove all child roles
        $oldRoles = $authManager->getChildRoles($role->name);
        foreach ($oldRoles as $oldRole) {
            $authManager->removeChild($role, $oldRole);
        }

        // Add New Child Roles
        if (is_array($childroles) && count($childroles) > 0) {


            // Add child roles if exist
            foreach ($childroles as $key => $childrole) {

                // Check role is exist or not
                $rbacRole = $authManager->getRole($childrole);

                if (!$rbacRole) {
                    $rbacRole = $authManager->createRole($childrole);
                }
                if ($rbacRole->name != $role->name) {
                    $authManager->addChild($role, $rbacRole);
                }

            }
        }
    }

    /**
     * @param string $id
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function remove(string $id):void
    {
        $authManager = $this->dbManager;

        $roleOrPerm = $authManager->getRole($id) ?? $authManager->getPermission($id);

        $authManager->remove($roleOrPerm);
    }

    /**
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function clearPermissionRule(string $id)
    {
        $authManager = $this->dbManager;
        $permission = $authManager->getPermission($id);
        $permission->ruleName = null;
        return $authManager->update($permission->name, $permission);
    }

    public function getRole($id)
    {
        $authManager = $this->dbManager;
        return $authManager->getRole($id);
    }

    public function getPermission(string $id)
    {
        $authManager = $this->dbManager;
        return $authManager->getPermission($id);
    }

    public function isRoleOrPerm(string $id):int
    {
        $authManager = $this->dbManager;
        return $authManager->getRole($id) ? 1 : 2;
    }

    public function getChildRoles(string $roleName)
    {
        $authManager = $this->dbManager;
        return $authManager->getChildRoles($roleName);
    }

    public function getRoles():array
    {
        $authManager = $this->dbManager;
        return $authManager->getRoles();
    }

    public function getRule(string $roleName)
    {
        $authManager = $this->dbManager;
        return $authManager->getRule($roleName);
    }

    /**
     * @param bool $hide - hide current role
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getRolesWithChildRoles(string $hideRole = null):array
    {
        $authManager = $this->dbManager;

        $childRoles = [];
        foreach ($authManager->getRoles() as $role) {

            if ($role->name != 'root') {

                $childs = $authManager->getChildRoles($role->name);

                $r = '';

                foreach ($childs as $childRoleName => $childRoleObj) {

                    if (isset($hideRole) && array_key_first($childs) == $hideRole ) {
                        break;
                    }

                    if (array_key_first($childs) == $childRoleName) {
                        $r .= $childRoleObj->name.' '.(count($childs) > 1 ? ' (' : '');//.' '.(count($childs));
                    } elseif (array_key_last($childs) == $childRoleName) {
                        $r .= $childRoleObj->name.' ';
                    } else {
                        $r .= $childRoleObj->name.', ';
                    }

                }
                $r .= (strlen($r) > 0 && count($childs) > 1 ? ')' : '');

                if (is_string($r) && strlen($r) > 0) {
                    $childRoles[$role->name] = $r;

                }

            }
        }
        return $childRoles;
    }

    public function getRolesWithChildRoles2(string $hideRole = null):array
    {
        $authManager = $this->dbManager;

        $r = [];
        $childRoles = $authManager->getRoles();

        foreach ($childRoles as $childRole) {
            if ($childRole->name != $hideRole) {
                $roleChildRoles = $authManager->getChildRoles($childRole->name);

                $f = '';
                foreach ($roleChildRoles as $name => $roleChildRole) {
                        $f .= $name . '__';
                }
                $f = substr($f, 0, strrpos($f,'__'));
                if ($f) {
                    $r[$f] = $f;
                }

            }
            //$this->dump(['role' => $childRoleName, 'f' => $f]);
            //$this->childroles[$f] = $f;
        }
        //$this->dump($r);
        return $r;
    }

    public function getRolesWithChildRoles3(string $roleName)
    {
        $authManager = $this->dbManager;

        $childRoles = $authManager->getRoles();

        $roles = [];

        foreach ($childRoles as $childRole) {

            $rs = $authManager->getChildRoles($childRole->name);

            $ss = [];
            foreach ($rs as $r) {
                if ($r->name != $childRole->name) {
                    $ss[] = $r->name;
                }
            }
            //$this->dump(['1' => $childRole->name, 'ss' => $ss]);

        }


        //$this->dump($roles);
        return $roles;
    }

    public function getRolesWithChildRoles4(string $roleName)
    {
        $authManager = $this->dbManager;
        $childRoles = $authManager->getRoles();
        $roles = [];

        foreach ($childRoles as $childRole) {
            $childRoles = $authManager->getChildRoles($childRole->name);

            $rr = [];
            $count = 0;
            foreach ($childRoles as $subChildRole) {
                if ($subChildRole->name != $childRole->name) {
                    $rr[] = $subChildRole->name;
                    $count++;
                }
            }


            if ($count) {
                $r = implode(', ', $rr);
            } else {
                $r = implode(' ', $rr);
            }


            if ($r && $childRole->name != $roleName) {
                //$roles[$childRole->name.'__'.implode('__',$rr)] = $childRole->name.'( '.$r.' )';
                $roles[$childRole->name.'__'.implode('__', $rr)] = $childRole->name.'( '.$r.' )';
            } else {
                $roles[$childRole->name] = $childRole->name;
            }
        }

        if (array_key_exists($roleName, $roles)) {
            unset($roles[$roleName]);
        }

        if (array_key_exists('root', $roles)) {
            unset($roles['root']);
        }

        //$this->dump($roles);
        return $roles;
    }

    /**
     * FIXME
     * @param string $roleName
     * @return array
     */
    public function getRolesWithChildRoles5(string $roleName)
    {
        $authManager = $this->dbManager;

        $allRoles = $authManager->getRoles();

        $roles = [];
        foreach ($allRoles as $role){
            if ($role->name != $roleName && $role->name != 'root') {
                $childRoles = $authManager->getChildRoles($role->name);
                $childRoleExist = false;
                foreach ($childRoles as $childRole) {
                    if ($childRole->name == $roleName) {
                        $childRoleExist = true;
                    }
                }
                if (!$childRoleExist && !$authManager->hasChild($role, $authManager->getRole($roleName))) {
                    $roles[$role->name] = $this->getChildRolesDescription($role->name);
                }
            }
        }
        return $roles;
    }

    public function getChildRolesDescription(string $roleName)
    {
        $roleObj = $this->dbManager->getRole($roleName);
        $childRoles = $this->dbManager->getChildRoles($roleObj->name);

        unset($childRoles[$roleName]);

        // From
        // super_editor ( content-manager, editor, user )
        // TO
        // super_editor ( editor, content-manager, user )
        //usort($childRoles, function ($roleObj1, $roleObj2) {

        //});

        $childRolesKeys = array_keys($childRoles);

        $childs = implode(', ', $childRolesKeys);

        if (count($childRolesKeys) > 0) {
            return $roleName.' ( '.$childs.' )';
        } else {
            return $roleName;
        }
    }

    public function getSelectedRoles(string $roleName, array $allRoles)
    {
        $authManager = $this->dbManager;
        $childRoles = $authManager->getChildRoles($roleName);

        $selectedRoles = [];
        foreach ($childRoles as $childRole) {
            if ($childRole->name != $roleName) {
                $selectedRoles[$childRole->name] = $childRole->name;
            }
        }
        return $selectedRoles;
    }

    /**
     * @param string $roleName
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getRoleChildRoles(string $roleName)
    {
        $authManager = $this->dbManager;

        $childRoles = $authManager->getChildRoles($roleName);

        $roles = '';
        if (count($childRoles) > 0) {
            foreach ($childRoles as $key => $child) {
                if (array_key_first($childRoles) != $key && array_key_last($childRoles) == $key) {
                    $roles .= $child->name;
                } elseif (array_key_first($childRoles) != $key && array_key_last($childRoles) > $key) {
                    $roles .= $child->name.', ';
                }
            }
        }
        return $roles;
    }


    /**
     * Add Rule To Role
     * @param string $roleName
     * @param $ruleName
     * @return bool
     * @throws \Exception
     */
    public function addRuleToRole(string $roleName, $ruleName):bool
    {
        $authManager = $this->dbManager;

        if (!strlen($ruleName)) {
            $ruleName = null;
        }

        $role = $authManager->getRole($roleName);
        $role->ruleName = $ruleName;
        return $authManager->update($role->name, $role);
    }

    /**
     * @param DbManager $authManager
     * @param $roleName
     * @param array $childRoles
     * @param array $roles
     * @return array
     */
    private function pack(DbManager $authManager, $roleName, array $roles): array
    {
        $childRoles = [];
        $childChildRoles = $authManager->getChildRoles($roleName);
        foreach ($childChildRoles as $childChildRoleName => $childChildRole) {
            $childRoles[] = $childChildRoleName;
        }



        if ($childRoles) {
            $roles[implode('__', $childRoles)] = implode('__', $childRoles);
        }

        //echo '<pre>';
        //print_r($roles);
        //echo '</pre>';die;

        $childRoles = null;
        return $roles;
    }

    private function dump($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';die;
    }
}