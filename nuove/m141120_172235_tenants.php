<?php

use yii\db\Schema;
use yii\db\Migration;

class m141120_172235_tenants extends Migration
{
    public function up()
    {
    	$this->createTable('tenants', [
            'id' => 'pk',
            'nome' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m141120_172235_tenants cannot be reverted.\n";
        return false;
    }
}
