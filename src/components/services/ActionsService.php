<?php
namespace yii2cmf\modules\rbac\components\services;

use yii\base\Component;

class ActionsService extends Component
{
    /**
     * @param string $className
     * @return array
     */
    public function getActionsFromController(string $className)
    {
        return ['create1' => 0, 'update2' => 0, 'view3' => 1, 'delete4' => 1, 'delete5' => 1, 'delete6' => 1, 'delete7' => 1, 'delete8' => 1, 'delete9' => 1, 'delete10' => 1, 'delete11' => 1, 'delete12' => 1, 'delete13' => 1, 'delete14' => 1, 'delete15' => 1, 'delete16' => 1];
    }

}