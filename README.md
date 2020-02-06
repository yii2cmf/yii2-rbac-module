# RBAC module
RBAC module that allows you to edit roles, permissions and rules using the web interface.
## Installation
The preferred way to install this extension is through composer.
```
$ composer require yii2cmf/yii2-rbac-module
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
php yii migrate/up --migrationPath=@vendor/yii2cmf/yii2-rbac-module/migrations
```

##### Module Default Page

http://your-project/rbac or http://your-project/module/rbac 


##### Update Permissions

![update_permissions](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/UpdatePerm2.png)



##### Update Permissions

![update-permissions](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/UpdatePerm1.png)

##### Default 

![index](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/RolesIndex.png)


##### Add Permission Rule

![update-rule](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/UpdateRule.png)


##### Add User Rule

![add-rule](https://raw.githubusercontent.com/shandyrov/images/master/modules/rbac/adminlte2/AddRule.png)
