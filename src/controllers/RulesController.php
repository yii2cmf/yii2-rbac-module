<?php
namespace yii2cmf\modules\rbac\controllers;

use Yii;
use app\modules\rbac\components\services\ModuleService;
use app\modules\rbac\Module;
use app\modules\rbac\models\AuthRuleModel;
use app\modules\rbac\components\services\AuthService;
use app\modules\rbac\models\AuthItem;
use app\modules\rbac\models\AuthItemSearch;
use yii\helpers\StringHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class RulesController extends Controller
{

    /**
     * @var $authService AuthService
     */
    public $authService;

    /**
     * @var $moduleService ModuleService
     */
    public $moduleService;

    public function __construct($id, $module, AuthService $authService, ModuleService $moduleService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
        $this->moduleService = $moduleService;
    }

    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search([
            StringHelper::basename(AuthItemSearch::class) => Yii::$app->request->queryParams
        ]);
        $dataProvider->query->andWhere(['type' => 2]);
        $dataProvider->query->andWhere(['not', ['rule_name' => null]]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView(string $id)
    {
        $model = AuthItem::findOne(['name' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new AuthRuleModel();

        list($modules, $controllers, $actions) = $this->getModulesControllersActions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Rule added.');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'modules' => $modules,
            'controllers' => $controllers,
            'actions' => $actions,
            'authRules' => $this->authService->authRules,
        ]);
    }

    public function actionUpdate(string $id)
    {
        $permission = $this->authService->getPermission($id);
        list($modules, $controllers, $actions) = $this->getModulesControllersActions();

        $name = explode('_', $permission->name);

        $model = new AuthRuleModel($permission->name);
        $model->module = $name[0];
        $model->controller = $name[1];
        $model->action = $name[2];
        $model->rule_name = $permission->ruleName;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'Rule updated.');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'modules' => $modules,
            'controllers' => $controllers,
            'actions' => $actions,
            'authRules' => $this->authService->authRules,
        ]);
    }

    /**
     * Clear Permission Rule
     * @param string $id ex: rbac_default_delete
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionDelete(string $id)
    {
        if ($this->authService->clearPermissionRule($id)) {
            Yii::$app->session->addFlash('success', Module::c('{permission} "{id}" is detached.',['permission' => 'Permission', 'id' => $id]));
        }
        return $this->redirect(['index']);
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getModulesControllersActions(): array
    {
        $modules = $this->moduleService->getModules();
        if (!$modules) {
            return [];
        }

        $controllers = $this->moduleService->getControllersShortName(reset($modules));

        if (!$controllers) {
            throw new \Exception("Controllers Not Found");
        }

        $actions = $this->moduleService->getControllerActions(reset($modules), ucfirst(reset($controllers)).'Controller');

        return [$modules, $controllers, $actions];
    }

    /**
     * Ajax
     * @return false|string
     * @throws \ReflectionException
     */
    public function actionLoadControllersActions()
    {
        if (($id = Yii::$app->request->post('id'))) {
            $controllers = $this->moduleService->getControllers($id);
            $controllersOptions = [];
            foreach ($controllers as $controller) {
                $fileInfo = pathinfo($controller);
                $controllersOptions[] = "<option value='".str_replace('controller', '', strtolower($fileInfo['filename']))."'>".str_replace('controller', '', strtolower($fileInfo['filename'])).'</option>';

            }

            $actions = $this->moduleService->getControllerActions($id, reset($controllers));
            $actionsOptions = [];
            foreach ($actions as $action) {
                $actionsOptions[] = "<option>".$action."</option>";
            }
            return json_encode([
                'controllers' => $controllersOptions,
                'actions' => $actionsOptions
            ]);
        }

        return json_encode([
            'controllers' => [],
            'actions' => []
        ]);
    }

    /**
     * Ajax
     * @return false|string
     * @throws \ReflectionException
     */
    public function actionLoadActions()
    {
        if (($moduleName = Yii::$app->request->post('module')) && ($controllerName = Yii::$app->request->post('controller'))) {
            $module = Yii::$app->getModule($moduleName);

            $reflectionClass = new \ReflectionClass($module->controllerNamespace.'\\'.ucfirst($controllerName).'Controller');

            $actions[] = array_filter($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC), function ($method) {
                return strstr($method->name,'action') !== false && $method->name !== 'actions' && strstr($method->class, 'yii') == false;
            });

            $actions = $this->moduleService->getControllerActions($moduleName, ucfirst($controllerName).'Controller');
            $actionsOptions = [];
            foreach ($actions as $action) {
                $actionsOptions[] = "<option>".$action."</option>";
            }

            return json_encode([
                'actions' => $actionsOptions
            ]);
        }

        return json_encode([
            'actions' => []
        ]);
    }
}