<?php
namespace yii2cmf\modules\rbac\models;

use yii2cmf\modules\rbac\Module;
use yii\base\Model;
use yii\rbac\DbManager;
use yii\rbac\Role;
use yii\web\BadRequestHttpException;
use yii2cmf\modules\rbac\components\services\AuthService;

class AuthItemRoleModel extends Model
{

    public $name;
    public $type;
    public $description;
    public $rule_name;
    public $data;
    public $childroles;

    private $oldRoleName;

    /**
     * @var AuthService
     */
    private $authService;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->authService = \Yii::$container->get(AuthService::class);

    }

    /**
     * {@inheritdoc}
     */
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
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function save():bool
    {
        $role = $this->authService->createAndAddRole($this->name);
        if ($role instanceof Role) {
            $this->authService->addChildRoles($role, is_array($this->childroles) ? $this->childroles : null);
            return true;
        }
        $this->addError('name', Module::e('Role "{id}" is already exist.', ['id' => $this->name]));
        return false;
    }

    public function update()
    {
//        try {
//            $role = $this->authService->updateRole($this->oldRoleName, $this->name,$this->description);
//            if ($role instanceof Role) {
//                $this->authService->updateChildRoles($role, is_array($this->childroles) ? $this->childroles : null);
//                return true;
//            }
//        } catch (\Exception $e) {
//            $this->addError('name', Module::e($e->getMessage()));
//        }
        //var_dump(['old role' => $this->oldRoleName , 'childroles' => explode('__', $this->childroles[0])]);die;

        /**
         * @var $dbManager DbManager
         */
        $dbManager = \Yii::$container->get(DbManager::class);


        //var_dump($this->childroles);die;
        if ($this->oldRoleName == $this->name && !$this->childroles) {
            return $dbManager->removeChildren($dbManager->getRole($this->oldRoleName));
        } elseif ($this->oldRoleName == $this->name && $this->childroles) {

            $newChildRole = explode('__', $this->childroles[array_key_first($this->childroles)]);

            $dbManager->addChild($dbManager->getRole($this->name), $dbManager->getRole($newChildRole[array_key_first($newChildRole)]));
        } else {
            var_dump([$this->oldRoleName, $this->name]);die;
        }

        return true;
    }

    public function fill(string $id, string $type)
    {
        $this->type = $type;

        switch ($type) {
            case 1: $this->fillRole($id);break;
            case 2: $this->fillPerm($id);break;
            default:
                throw new BadRequestHttpException("Parameter type is wrong.");
        }
    }

    private function fillRole(string $id)
    {
        /**
         * @var $role Role
         */
        $role = $this->authService->getRole($id);
        $this->oldRoleName = $role->name;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->type = $role->type;
        $this->data = $role->data;

        /**
         * @var $dbManager DbManager
         */
        $dbManager = \Yii::$container->get(DbManager::class);

        $dublicate = [];
        foreach ($this->authService->getChildRoles($role->name) as $childRoleName => $childRole){
            $childRoles = $dbManager->getChildRoles($childRoleName);
            $d = [];

            if (count($childRoles) == 1) {
                //$d[] = $childRoleName;
            } else {

                $s = [];
                foreach ($childRoles as $childChildRoleName => $childRole) {
                    //if ($childRoleName != $role->name) {
                        $s[] = $childChildRoleName;
                    //}
                }
            }

            $d = array_unique($dublicate);
            //echo '<pre>';
            //print_r($d);
            //echo '</pre>';

            if ($d) {
                $this->childroles[implode('__', $d)] = implode('__', $d);

            }
        }

        //echo '<pre>';
        //print_r($this->childroles);
        //echo '</pre>';die;

        return $this->childroles;
    }

    private function fillPerm(string $id)
    {
        $perm = $this->authService->getPermission($id);
        $this->name = $id;
        $this->description = $perm->description;
        $this->type = $perm->type;
        $this->data = $perm->data;
    }
}