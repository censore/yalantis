<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_135424_history extends Migration
{
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    public function safeUp()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";

        /* MYSQL */
        if (!in_array('history', $tables))  {
            if ($dbType == "mysql") {
                $this->createTable('{{%history}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT', 0 => 'PRIMARY KEY (`id`)',
                    'photo_id' => 'INT(11) NULL',
                    'hsize' => 'INT(11) NULL',
                    'wsize' => 'INT(11) NULL',
                    'quality' => 'INT(11) NULL',
                    'colored' => 'INT(11) NULL',
                    'result' => 'VARCHAR(255) NULL',
                ], $tableOptions_mysql);
            }
        }

        $this->createIndex('idx_photo_id_3973_00','history','photo_id',0);
    }

    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `history`');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
