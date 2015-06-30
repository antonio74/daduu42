<?php

use yii\db\Schema;
use yii\db\Migration;

class m141214_105209_groups extends Migration
{
    public function up()
    {
    	$this->createTable('groups', [
            'id' => 'pk',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT
        ]);
    }

    public function down()
    {
        echo "m141214_105209_groups cannot be reverted.\n";
        return false;
    }
}
