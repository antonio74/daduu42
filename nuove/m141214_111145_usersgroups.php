<?php

use yii\db\Schema;
use yii\db\Migration;

class m141214_111145_usersgroups extends Migration
{
    public function up()
    {
    	$this->createTable('usersgroups', [
            'id' => 'pk',
            'id_user' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_group' => Schema::TYPE_INTEGER . ' NOT NULL'
        ]);
        $this->addForeignKey('FK_user', 'usersgroups', 'id_user', 'user', 'id', 'CASCADE', 'CASCADE');  
        $this->addForeignKey('FK_group', 'usersgroups', 'id_group', 'groups', 'id', 'CASCADE', 'CASCADE');    
    }

    public function down()
    {
        echo "m141214_111145_usersgroups cannot be reverted.\n";
        $this->dropTable('usersgroups');
        return false;
    }
}
