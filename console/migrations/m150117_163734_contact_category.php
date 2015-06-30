<?php

use yii\db\Schema;
use yii\db\Migration;

class m150117_163734_contact_category extends Migration
{
    public function up()
    {
    	$this->createTable('contact_category', [
    		'id' => 'pk',
        	'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
    	$this->dropTable('contact_category');    	
        echo "m150117_163734_contact_category was dropped.\n";

        return false;
    }
}
