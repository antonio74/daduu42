<?php

use yii\db\Schema;
use yii\db\Migration;

class m150117_163645_tenant extends Migration
{
    public function up()
    {
    	$this->createTable('tenant', [
    		'id' => 'pk',
        	'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);        	
    }

    public function down()
    {
    	$this->dropTable('tenant');    	
        echo "m150117_163645_tenant was dropped.\n";

        return false;
    }
}
