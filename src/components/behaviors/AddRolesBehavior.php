<?php
namespace yii2cmf\modules\rbac\components\behaviors;

use yii2cmf\modules\rbac\components\services\AuthService;
use yii2cmf\modules\rbac\models\AuthItem;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

class AddRolesBehavior extends Behavior
{
    /**
     * @var $authService AuthService
     */
    private $authService;

    public function __construct(AuthService $authService, $config = [])
    {
        parent::__construct($config);
        $this->authService = $authService;
    }

    public function events():array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert'
        ];
    }

    public function beforeInsert(Event $event ):bool
    {
        /**
         * @var $model AuthItem
         */
        $model = $this->owner;
        try{
            $role = $this->authService->createAndAddRole($model->name);
            $this->authService->addChildRoles($role, $model->childroles);
        } catch (\Exception $e) {
            return true;
        }
        return false;

    }


}