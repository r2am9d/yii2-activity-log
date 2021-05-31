<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity_log}}`.
 */
class m210531_190149_create_activity_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";

        /* MYSQL */
        if (!in_array('activity_log', $tables))  { 
        if ($dbType == "mysql") {
            $this->createTable('{{%activity_log}}', [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                0 => 'PRIMARY KEY (`id`)',
                'user_id' => 'INT(11) NOT NULL',
                'type' => 'ENUM(\'Controller\',\'Model\') NOT NULL',
                'class' => 'VARCHAR(255) NOT NULL',
                'method' => 'VARCHAR(255) NOT NULL',
                'route' => 'VARCHAR(255) NULL',
                'data' => 'LONGBLOB NULL',
                'created_at' => 'INT(11) NOT NULL',
                'updated_at' => 'INT(11) NOT NULL',
            ], $tableOptions_mysql);
        }
        }
        
        
        $this->createIndex('idx_user_id_7507_00','activity_log','user_id',0);
        
        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_user_7495_00','{{%activity_log}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `activity_log`');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
