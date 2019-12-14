<?php
namespace yii2cmf\modules\rbac\rules;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param int|string $user id
     * @param \yii\rbac\Item $item role or permission with which this rule is associated
     * @param array $params parameters passed to ManagerInterface :: checkAccess (), for example, when checking is called
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['post']) ? $params['post']->post_author == $user : false;
    }
}