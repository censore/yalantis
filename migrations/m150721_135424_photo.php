<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_135424_photo extends Migration
{
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    public function safeUp()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";

        /* MYSQL */
        if (!in_array('photo', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%photo}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'user_id' => 'INT(11) UNSIGNED NOT NULL',
                    'type' => 'VARCHAR(100) NULL',
                    'path' => 'VARCHAR(255) NULL',
                    'file' => 'VARCHAR(255) NULL',
                    'h' => 'INT(8) NULL',
                    'w' => 'INT(8) NULL',
                    'q' => 'INT(3) NULL',
                    'created_at' => 'TIMESTAMP NULL',
                    'updated_at' => 'TIMESTAMP NULL',
                ], $tableOptions_mysql);
            }
        }

    }

    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `photo`');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
