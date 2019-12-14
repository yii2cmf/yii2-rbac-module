<?php
namespace yii2cmf\modules\rbac\components\services;

use Yii;
use yii2cmf\modules\rbac\Module;
use yii2cmf\modules\rbac\models\AuthItemChild;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\rbac\DbManager;

class ModuleService extends Component
{

    /**
     * @return array
     */
    public function getModules()
    {
        /**
         * @var $rbac Module
         */
        $rbac = Yii::$app->getModule('rbac');

        $modules = [];
        foreach (Yii::$app->getModules() as $id => $module) {
            if ((isset($rbac->exclude) && !in_array($id, $rbac->exclude)) || !$rbac->exclude) {
                if (!is_object($module)) {
                    $module = Yii::$app->getModule($id);
                }
                $modules[$module->id] = $module->id;
            }
        }
        return $modules;
    }

    /**
     * Return Controllers Array
     * Example output: array(1) { [0]=> string(17) "DefaultController" }
     * @param string $moduleId
     * @return array
     * @throws \Exception If Module Not Exist
     */
    public function getControllers(string $moduleId)
    {
        if (!($module = Yii::$app->getModule($moduleId))) {
            throw new Exception("Module: $moduleId Not Exist");
        }

        $controllers = [];
        $controllersFiles = FileHelper::findFiles($module->getControllerPath());

        foreach ($controllersFiles as $controllersFile) {
            $fileInfo = pathinfo($controllersFile);
            $controllers[$fileInfo['filename']] =  $fileInfo['filename'];
        }
        return $controllers;
    }

    /**
     * Return Controllers Array
     * Example output: array(1) { [0]=> string(17) "DefaultController" }
     * @param string $moduleId
     * @return array
     * @throws \Exception If Module Not Exist
     */
    public function getControllersShortName(string $moduleId)
    {
        if (!($module = Yii::$app->getModule($moduleId))) {
            throw new Exception("Module: $moduleId Not Exist");
        }

        $controllers = [];
        $controllersFiles = FileHelper::findFiles($module->getControllerPath());

        foreach ($controllersFiles as $controllersFile) {
            $fileInfo = pathinfo($controllersFile);
            $controllerShortName = str_replace('controller', '', strtolower($fileInfo['filename']));
            $controllers[$controllerShortName] =  $controllerShortName;
        }
        return $controllers;
    }

    /**
     * @param string $moduleId
     * @param string $controllerId
     * @return array
     * @throws \ReflectionException
     */
    public function getControllerActions(string $moduleId, string $controllerId)
    {
        $pathInfo = pathinfo($controllerId);
        $reflectionClass = new \ReflectionClass(Yii::$app->getModule($moduleId)->controllerNamespace.'\\'.$pathInfo['filename']);

        $methods = array_filter($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC), function ($method){
            return strstr($method->name,'action') !== false && $method->name !== 'actions' && $method->name !== 'actions' && substr($method->class, 0, strpos($method->class, '\\')) != 'yii';//strstr($method->name,'action') !== false && $method->name !== 'actions' && strstr($method->class, 'yii') == false;
        });
        //echo '<pre>';
        //print_r($methods);
        //echo '</pre>';

        $actions = [];

        foreach ($methods as $method) {
            $action = strtolower(str_replace('action', '', $method->name));
            /**
             * @var $method \ReflectionMethod
             */
            $actions[$action] = $action;
        }
        return $actions;
    }

    /**
     * @param string $moduleId
     * @param string $controllerId
     * @return array
     * @throws \ReflectionException
     */
    public function getControllerActions1(string $role, string $moduleId, string $controllerId)
    {
        $pathInfo = pathinfo($controllerId);
        $reflectionClass = new \ReflectionClass(Yii::$app->getModule($moduleId)->controllerNamespace.'\\'.$pathInfo['filename']);
        $methods = array_filter($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC), function ($method){
            return strstr($method->name,'action') !== false && $method->name !== 'actions' && strstr($method->class, 'yii') == false;
        });

        $actions = [];

        $itemsChild = AuthItemChild::find()->where(['parent' => $role])->select(['child'])->asArray()->all();

        $childActions = [];
        foreach ($itemsChild as $itemChild) {
            //var_dump($itemChild);die;

            $childActions[$itemChild['child']] = $itemChild['child'];
            //var_dump($t);die;
        }

        //echo '<pre>';
        //print_r($childActions);
        //echo '</pre>';die;

        //var_dump($itemsChild);die;
        foreach ($methods as $method) {
            $action = strtolower(str_replace('action', '', $method->name));
            /**
             * @var $method \ReflectionMethod
             */
            $c = str_replace('controller', '',strtolower($controllerId));
            $actions[$action] = in_array($moduleId.'_'.$c.'_'.$action, $childActions);//$this->isChecked($moduleId, $controllerId, $action);
        }

        //var_dump($childActions);die;
        return $actions;
    }

    /**
     * @param string $moduleId
     * @param string $controllerId
     * @return array
     * @throws \ReflectionException
     */
    public function getControllerActionsReverse(string $role, string $moduleId, string $controllerId)
    {
        $pathInfo = pathinfo($controllerId);
        $reflectionClass = new \ReflectionClass(Yii::$app->getModule($moduleId)->controllerNamespace.'\\'.$pathInfo['filename']);

        $methods = array_filter($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC), function ($method){
            return strstr($method->name,'action') !== false && $method->name !== 'actions' && strstr($method->class, 'yii') == false;
        });

        $actions = [];

        $itemsChild = AuthItemChild::find()->where(['parent' => $role])->select(['child'])->asArray()->all();

        $childActions = [];
        foreach ($itemsChild as $itemChild) {
            //var_dump($itemChild);die;

            $childActions[$itemChild['child']] = $itemChild['child'];
            //var_dump($t);die;
        }


        foreach ($methods as $method) {

            $action = strtolower(str_replace('action', '', $method->name));
            /**
             * @var $method \ReflectionMethod
             */
            $c = str_replace('controller', '',strtolower($controllerId));
            $actions[$action] = (int)in_array($moduleId.'_'.$c.'_'.$action, $childActions);
        }
        return $actions;
    }

    /**
     * @param string $moduleId
     * @param string $controllerId
     * @return array
     * @throws \ReflectionException
     */
    public function getControllerActionsReverse2(string $role, string $moduleId, string $controllerId)
    {
        $pathInfo = pathinfo($controllerId);
        $reflectionClass = new \ReflectionClass(Yii::$app->getModule($moduleId)->controllerNamespace.'\\'.$pathInfo['filename']);

        $methods = array_filter($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC), function ($method){
            return strstr($method->name,'action') !== false && $method->name !== 'actions' && strstr($method->class, 'yii') == false;
        });

        $actions = [];
        /**
         * @var $authManager DbManager
         */
        $authManager = Yii::$app->getModule('rbac')->authManager;
        $childRoles = $authManager->getChildRoles($role);
        //echo '<pre>';
        //print_r($childRoles);die;
        //echo '</pre>';die;

        foreach ($childRoles as $moduleName => $role) {
            //var_dump($role);die;
            //$itemsChilds[$moduleName] = AuthItemChild::find()->where(['parent' => $role->name])->select(['child'])->asArray()->all();
            $itemsChilds[] = $authManager->getPermissionsByRole($role->name);
        }

        //echo '<pre>';
        //print_r($itemsChilds);
        //echo '</pre>';die;

        $childActions = [];
        foreach ($itemsChilds as $key => $itemChild) {

            foreach ($itemChild as $permissionName => $item) {
                //var_dump($permissionName);die;
                $childActions[$item->name] = $item->name;
            }
            //$childActions[$itemChild['child']] = $itemChild['child'];
            //
        }
        //var_dump($childActions);die;

        foreach ($methods as $method) {

            $action = strtolower(str_replace('action', '', $method->name));
            /**
             * @var $method \ReflectionMethod
             */
            $c = str_replace('controller', '',strtolower($controllerId));
            $actions[$action] = (int)in_array($moduleId.'_'.$c.'_'.$action, $childActions);
        }
        return $actions;
    }
}
