<?php

use yii\db\Schema;
use yii\db\Migration;

class m150117_171550_contact_group extends Migration
{
    public function up()
    {
    	$this->createTable('contact_group', [
    		'id' => 'pk',
        	'name' => Schema::TYPE_STRING . ' NOT NULL',
        	'visibility' => Schema::TYPE_STRING . ' NOT NULL',
        	'permissions' => Schema::TYPE_STRING . ' NOT NULL',
        	'read_write' => Schema::TYPE_STRING . ' NOT NULL',        	
        ]);        	
    }

    public function down()
    {
    	$this->dropTable('contact_group');    	
        echo "m150117_171550_contact_group was dropped.\n";

        return false;
    }
}
