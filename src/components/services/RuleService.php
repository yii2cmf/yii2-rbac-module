<?php
namespace yii2cmf\modules\rbac\components\services;

use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\rbac\DbManager;
use yii\rbac\Rule;

class RuleService extends Component
{
    private $dbManager;

    public function __construct(DbManager $dbManager, $config = [])
    {
        parent::__construct($config);
        $this->dbManager = $dbManager;
    }

    /**
     * @param array $rules
     * @throws \Exception
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $rule) {
            $path = Yii::getAlias('@' . str_replace('\\', '/', $rule));
            if (file_exists($path)) {
                $classNames = FileHelper::findFiles($path);
                foreach ($classNames as $className) {

                    $class = $rule.'\\'.str_replace('.php','',substr($className,((int)strrpos($className,'/'))+1));

                    if (get_parent_class($class) == Rule::class) {
                        $authManager = $this->dbManager;

                        $ruleObj = new $class;
                        $rul = $authManager->getRule($ruleObj->name);
                        if (!$rul) {
                            $authManager->add($ruleObj);
                        }
                    }
                }
            }
        }
    }

}