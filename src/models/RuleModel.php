<?php
namespace yii2cmf\modules\rbac\models;

use yii\base\Model;
use yii\rbac\DbManager;

class RuleModel extends Model
{
    public $role;
    public $rule_name;

    private $authManager;

    public function __construct(string $role, DbManager $authManager, $config = [])
    {
        $this->role = $role;
        $this->authManager = $authManager;
        $this->rule_name = $this->authManager->getRole($role)->ruleName;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['role'], 'required'],
            [['rule_name', 'role'], 'string', 'max' => 255],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::class, 'targetAttribute' => ['rule_name' => 'name']]
        ];
    }

    public function save():bool
    {
        if (!strlen($this->rule_name)) {
            $this->rule_name = null;
        }

        $role = $this->authManager->getRole($this->role);
        $role->ruleName = $this->rule_name;
        return $this->authManager->update($role->name, $role);
    }


}