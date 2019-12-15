<?php
namespace yii2cmf\modules\rbac\migrations;

use Yii;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m191215_075504_create_user_table extends Migration
{
     /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       if ($this->isTableNotExist()) {

           $tableOptions = null;
           if ($this->db->driverName === 'mysql') {
               // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
               $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
           }

           $this->createTable('{{%user}}', [
               'id' => $this->primaryKey(),
               'username' => $this->string()->notNull()->unique(),
               'auth_key' => $this->string(32)->notNull(),
               'password_hash' => $this->string()->notNull(),
               'password_reset_token' => $this->string()->unique(),
               'email' => $this->string()->notNull()->unique(),

               'status' => $this->smallInteger()->notNull()->defaultValue(10),
               'created_at' => $this->integer()->notNull(),
               'updated_at' => $this->integer()->notNull(),
               'verification_token' => $this->string()->defaultValue(null)
           ], $tableOptions);

       }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (!$this->isTableNotExist()) {
            $this->dropTable('{{%user}}');
        }
    }

    private function isTableNotExist()
    {
        $tablePrefix = Yii::$app->db->tablePrefix;
        return $this->db->getTableSchema($tablePrefix.'user', true) === null;
    }
}
