<?php

use yii\db\Schema;
use yii\db\Migration;

class m141214_190215_gruppipermessi extends Migration
{
    public function up()
    {
    	$this->addColumn('gruppo', 'visibilità', Schema::TYPE_STRING . ' not null');
    	$this->addColumn('gruppo', 'autorizzati', Schema::TYPE_STRING);
     	$this->addColumn('gruppo', 'permessi', Schema::TYPE_STRING . ' not null');	
    }

    public function down()
    {
        echo "m141214_190215_gruppipermessi cannot be reverted.\n";

        return false;
    }
}
