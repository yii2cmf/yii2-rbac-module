<?php
namespace yii2cmf\modules\rbac\controllers;

use Yii;

use yii2cmf\modules\rbac\models\{
    ActionsForm,
    RoleModel,
    RuleModel,
    AuthItem,
    AuthItemRoleModel,
    AuthItemSearch,
};
use yii2cmf\modules\rbac\Module;
use yii2cmf\modules\rbac\components\services\AuthService;
use yii\helpers\StringHelper;
use yii\web\Controller;

class RolesController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;



    public function __construct($id, $module, AuthService $authService, $config = [])
    {
        $this->authService = $authService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search([
            StringHelper::basename(AuthItemSearch::class) => Yii::$app->request->queryParams
        ]);
        $dataProvider->query->andWhere(['type' => 1]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param string $id
     * @return string
     */
    public function actionView(string $id)
    {
        $model = AuthItem::findOne(['name' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws yii\base\Exception
     * @throws yii\base\InvalidConfigException
     * @throws yii\di\NotInstantiableException
     */
    public function actionCreate()
    {
        $model = new AuthItemRoleModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Module::c('Role {name} is created.', ['name' => $model->name]));

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'childRoles' => $this->authService->getRolesWithChildRoles()
        ]);
    }

    /**
     * @param string $id
     * @return string|yii\web\Response
     */
    public function actionUpdate(string $id)
    {

        $model = new RoleModel($id, $this->module->authManager);
        $roles = $this->authService->getRolesWithChildRoles5($id);
        $model->childroles = $this->authService->getSelectedRoles($id, $roles);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->addFlash('success', Module::c('Role {name} is updated.', ['name' => $model->name]));
            return $this->redirect(['update', 'id' => $model->name]);
        }


        return $this->render('update', [
            'model' => $model,
            'childRoles' => $roles
        ]);
    }

    /**
     * @param string $id
     * @return yii\web\Response
     * @throws yii\base\InvalidConfigException
     * @throws yii\di\NotInstantiableException
     */
    public function actionDelete(string $id)
    {
        $this->authService->remove($id);
        return $this->redirect(['index']);
    }

    /**
     * Add/Remove Rule
     * @param string $role
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionRule(string $role)
    {
        $authRules = $this->authService->getAuthRules();
        $model = new RuleModel($role, $this->module->authManager);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Module::c('Rule added'));
            $this->redirect(['index']);
        }

        return $this->render('rule', [
            'model' => $model,
            'authRules' => $authRules,
        ]);
    }

    /**
     * @param string $role
     * @return string
     */
    public function actionPermissions(string $role)
    {
        $model = new ActionsForm($role);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Module::c('Permissions is added.'));
            $model->prepare($role);
        }

        return $this->render('permissions', [
            'role' => $role,
            'model' => $model
        ]);
    }

}