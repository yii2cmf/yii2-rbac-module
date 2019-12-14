<?php
namespace rbac;

use app\modules\rbac\models\AuthRule;
use Codeception\Util\Locator;

class _01_RoleCest
{
    const RBAC_ROLES_INDEX = 'rbac/roles/index';
    const RBAC_ROLES_VIEW = 'rbac/roles/view';

    private $roleName;

    public function __construct()
    {
        $this->roleName = 'test_role_'.mt_rand(1,1000);
    }

    public function _before(AcceptanceTester $I)
    {

    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function createRole(AcceptanceTester $I)
    {
        $I->amOnPage(self::RBAC_ROLES_INDEX);
        // Add Button
        $I->seeElement('.btn-primary');
        $I->click(['class' => 'btn-primary']);
        $I->wait(1);
        $I->seeElement(Locator::find('button',['type' => 'submit']));
        $I->seeElement('#authitemrolemodel-name');
        $I->seeElement('#authitemrolemodel-description');

        $I->fillField('input[name="AuthItemRoleModel[name]"]', $this->roleName);
        $I->fillField('textarea[name="AuthItemRoleModel[description]"]', 'test desc');
        $I->click(Locator::find('button',['type' => 'submit']));
        $I->wait(1);
        //var_dump($buttonName);
    }

    public function viewRole(AcceptanceTester $I)
    {
        $I->amOnPage(self::RBAC_ROLES_VIEW.'?id='.$this->roleName);
        $I->see($this->roleName);
    }

    public function updateRole(AcceptanceTester $I)
    {
        $I->amOnPage(self::RBAC_ROLES_INDEX);
        $I->click(Locator::contains('.table tr[data-key="'.$this->roleName.'"] a>span.glyphicon-pencil', ''));

        $I->wait(1);
        $I->fillField('input[name="RoleModel[name]"]', $this->roleName.'_1');
        $I->fillField('textarea[name="RoleModel[description]"]', 'test desc_1');
        $I->click(Locator::find('button',['type' => 'submit']));
        $I->wait(2);
        $I->seeElement('.alert-success');
    }

    public function addEditRule(AcceptanceTester $I)
    {
        $I->amOnPage(self::RBAC_ROLES_INDEX);
        $I->seeElement('.table');
        $I->seeElement('.glyphicon-list-alt');

        $I->click(Locator::contains('.table tr[data-key="'.$this->roleName.'"] a>span.glyphicon-list-alt', ''));
        $I->wait(2);
        $I->seeElement('#roleaddrulemodel-rule_name');
        $I->seeElement(Locator::find('button',['type' => 'submit']));
        $I->click(Locator::find('button',['type' => 'submit']));
        //$I->seeElement(Locator::option('Male'), '#select-gender');
        $row = AuthRule::find()->asArray()->one();
        $I->selectOption($row['name'], $row['name']);
        $I->click(Locator::find('button',['type' => 'submit']));
    }

    // TODO
    public function addEditPermissions(AcceptanceTester $I)
    {
        $I->amOnPage(self::RBAC_ROLES_INDEX);
        $I->seeElement('.glyphicon-lock');
        $I->click(Locator::contains('.table tr[data-key="'.$this->roleName.'"] a>span.glyphicon-lock', ''));
        $I->wait(2);
        $I->click(Locator::find('button',['type' => 'submit']));
        // Click on checkbox
        // Save
    }

    public function deleteRole(AcceptanceTester $I)
    {
        $I->amOnPage(self::RBAC_ROLES_INDEX);
        $I->wait(1);
        $I->click(Locator::contains('.table tr[data-key="'.$this->roleName.'_1"] a>span.glyphicon-trash', ''));
        $I->wait(1);
        $I->acceptPopup();
        $I->dontSeeElement('.table tr[data-key="'.$this->roleName.'_1"]');
    }
}
