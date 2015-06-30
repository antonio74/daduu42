<?php

use yii\db\Schema;
use yii\db\Migration;

class m141015_153906_newrubrica extends Migration
{
    public function up()
    {
    	$this->createTable('newrubrica', [
            'id' => 'pk',
            'cognome' => Schema::TYPE_STRING . ' NOT NULL',
            'nome' => Schema::TYPE_STRING . ' NOT NULL',
            'mobile' => Schema::TYPE_STRING ,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m141015_153906_newrubrica cannot be reverted.\n";

        return false;
    }
}
