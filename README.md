# RBAC module
RBAC module that allows you to edit roles, permissions and rules using the web interface.
## Installation
The preferred way to install this extension is through composer.
```
$ composer require --prefer-dist yii2cmf/yii2-rbac-module
```
or add
```
"yii2cmf/yii2-rbac-module": "*"
```
to the require section of your composer.json file.

In config/web.php 
```php
'modules' => [
    ...
    'rbac' => [
        'class' => 'app\modules\rbac\Module',
        // Excluded Modules
        'exclude' => ['gii', 'debug'],
        
        // Set rules path 
        'rules' => ['app\modules\rbac\rules', 'app\commands', '...'],
    ],
    ...
];

```
##### Apply migrations
```
php yii migrate/down --migrationPath=@vendor/yii2cmf/yii2-rbac-module/migrations
```

##### Update Permissions

http://your-project/rbac/roles

![update_permissions](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/UpdatePerm2.png)



##### Update Permissions

![update-permissions](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/UpdatePerm1.png)

http://your-project/rbac/rules

![rules](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/RolesIndex.png)


##### Add Rule

![add-rule](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/AddRule.png)
