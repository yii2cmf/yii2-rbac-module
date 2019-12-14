<?php
namespace yii2cmf\modules\rbac\components\services;

use yii\base\Component;

class StringService extends Component
{


    public function removeLastCharacter($str)
    {
        return substr($str, 0, strrpos($str, ','));
    }


}