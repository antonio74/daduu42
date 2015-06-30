<?php

use yii\db\Schema;
use yii\db\Migration;

class m150117_170329_user_group extends Migration
{
    public function up()
    {
    	$this->createTable('user_group', [
            'id' => 'pk',
            'tenant_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
    	$this->dropTable('user_group');
        echo "m150117_170329_user_group was dropped.\n";
        return false;
    }
}
