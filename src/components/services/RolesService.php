<?php
namespace yii2cmf\modules\rbac\components\services;

use yii\base\Component;
use yii\rbac\DbManager;

class RolesService extends Component
{
    /**
     * @var $authManager DbManager
     */
    private $authManager;

    public function __construct(DbManager $authManager, $config = [])
    {
        parent::__construct($config);
    }

    public function getChildRoles(string $roleName):array
    {
        $childRoles = $this->authManager->getChildRoles($roleName);
        echo '<pre>';
        print_r($childRoles);
        echo '</pre>';die;
        return [];
    }

}