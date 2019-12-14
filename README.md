RBAC module.
============
RBAC module that allows you to edit roles, permissions, and rules using the web interface.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2cmf/yii2-rbac-module "*"
```

or add

```
"yii2cmf/yii2-rbac-module": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \yii2cmf\modules\rbac\AutoloadExample::widget(); ?>```