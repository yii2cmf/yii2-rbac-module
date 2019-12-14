<?php
namespace yii2cmf\modules\rbac;

use Yii;
use yii2cmf\modules\rbac\components\services\RuleService;
use yii2cmf\modules\rbac\Module as M;


/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
{

    public $exclude = ['mediator', 'gii', 'debug'];
    public $rules;
    public $defaultRoute = 'roles';
    public $adminModule;

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'yii2cmf\modules\rbac\controllers';



    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::configure($this, ['params' => require __DIR__.'/config/params.php']);
        $this->registerTranslations();
        $this->addRules();
    }

    /**
     * @return array
     */
    public function getMenu()
    {
        $module = Yii::$app->controller->module->id;
        $controller = Yii::$app->controller->id;
        $active = $module == $this->id;
        $adminModule = isset($this->params['adminModule']) ? '/'.$this->params['adminModule'] : '';
        return
            [
                'label' => strtoupper($this->id), 'url' => '#', 'active' => $active,
                'items' => [
                    [
                        'label' => M::c('Roles'),
                        'url' => [$adminModule.'/'.$this->id.'/roles'],
                        'active' => $active && $controller == 'roles',
                    ],
                    [
                        'label' => Module::c('Rules'),
                        'url' => [$adminModule.'/'.$this->id.'/rules'],
                        'active' => $active && $controller == 'rules'
                    ],
                ]
            ];
    }

    public function registerTranslations()
    {
        // Common
        Yii::$app->i18n->translations['modules/'.$this->id.'/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => __DIR__.'/messages',
            'fileMap' => [
                'modules/'.$this->id.'/common' => 'common.php',
                'modules/'.$this->id.'/msg' => 'msg.php',
                'modules/'.$this->id.'/error' => 'error.php',
            ],
        ];
    }

    // Insert new rules in auth_rules table
    private function addRules(): void
    {
        $ruleService = Yii::$container->get(RuleService::class);
        $ruleService->addRules($this->rules);
    }

    public static function c($message, $params = [], $language = null)
    {
        return Yii::t('modules/rbac/common', $message, $params, $language);
    }
    public static function e($message, $params = [], $language = null)
    {
        return Yii::t('modules/rbac/error', $message, $params, $language);
    }
    public static function m($message, $params = [], $language = null)
    {
        return Yii::t('modules/rbac/msg', $message, $params, $language);
    }


}
