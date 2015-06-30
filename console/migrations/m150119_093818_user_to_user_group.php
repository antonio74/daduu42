<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_093818_user_to_user_group extends Migration
{
    public function up()
    {
    	$this->createTable('user_to_user_group', [
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_group_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'PRIMARY KEY (user_id, user_group_id)',

        ]);
        $this->addForeignKey('FK_user', 'user_to_user_group', 'user_id', 'user', 'id', 'CASCADE', 'NO ACTION');
    	$this->addForeignKey('FK_user_group', 'user_to_user_group', 'user_group_id', 'user_group', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('user_to_user_group');    	
        echo "m150119_093818_user_to_user_group was dropped.\n";

        return false;
    }
}
