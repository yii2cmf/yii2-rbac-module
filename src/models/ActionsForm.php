<?php
namespace yii2cmf\modules\rbac\models;

use yii2cmf\modules\rbac\components\services\ModuleService;
use yii\base\Model;

class ActionsForm extends Model
{
    public $controller;
    public $actions = [];
    public $actionService;
    public $role;

    /**
     * @var ModuleService
     */
    public $moduleService;

    /**
     * $container[$moduleId][$controllerId] = ['actions' => ['index', ...]]
     * @var $container array
     */
    public $container;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['actions', 'controller'], 'safe'],
        ];
    }

    public function __construct(string $role, $config = [])
    {
        parent::__construct($config);
        $this->prepare($role);
    }

    public function save():bool
    {

        foreach ($this->actions as $moduleName => $controller) {

            foreach ($controller as $controllerName => $actions) {

                foreach ($actions as $actionName => $value) {
                    $controllerName = str_replace('controller', '',strtolower($controllerName));

                    $name = $moduleName.'_'.$controllerName.'_'.$actionName;
                    $perm[$name] = (int)$value;

                    // Check if permission exist
                    $authItemModel = AuthItem::find()->where(['name' => $name])->asArray()->one();
                    if (!$authItemModel) {
                        // If permission not exist

                        $authItemModel = new AuthItem();
                        $authItemModel->name = $name;
                        $authItemModel->type = 2;
                        $authItemModel->description = null;
                        $authItemModel->rule_name = null;
                        $authItemModel->data = null;
                        $authItemModel->save(false);
                    }

                    // if value is 1 -assign, 0 -revoke permission

                    // Assign permission
                    if($value){
                        $authItemChild = AuthItemChild::find()->where(['parent' => $this->role, 'child' => $name])->one();
                        if (!$authItemChild) {
                            $authItemChild = new AuthItemChild();
                            $authItemChild->parent = $this->role;
                            $authItemChild->child = $name;
                            $authItemChild->save(false);
                        }


                    // Revoke permission
                    } else {
                        $authItemChild = AuthItemChild::find()->where(['parent' => $this->role, 'child' => $name])->one();
                        if ($authItemChild) {
                            $authItemChild->delete();
                        }
                    }
                }
            }
        }
        return true;
    }

    // FIXME
    public function prepare(string $role)
    {
        $this->role = $role;
        $this->moduleService = \Yii::$container->get(ModuleService::class);

        $modules = $this->moduleService->getModules();

        foreach ($modules as  $moduleId) {
            $controllers = $this->moduleService->getControllers($moduleId);

            foreach ($controllers as $controllerId) {
                $this->container[$moduleId][$controllerId] = ['actions' => $this->moduleService->getControllerActionsReverse($role, $moduleId, $controllerId)];
            }
        }
    }
}
