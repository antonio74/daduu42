<?php

use yii\db\Schema;
use yii\db\Migration;

class m141027_055344_gruppicontatti extends Migration
{
    public function up()
    {
    	$this->createTable('gruppicontatti', [
            'id' => 'pk',
            'id_contatto' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_gruppo' => Schema::TYPE_INTEGER . ' NOT NULL'
        ]);
        $this->addForeignKey('FK_contatto', 'gruppicontatti', 'id_contatto', 'newrubrica', 'id', 'CASCADE', 'CASCADE');  
        $this->addForeignKey('FK_gruppo', 'gruppicontatti', 'id_gruppo', 'gruppo', 'id', 'CASCADE', 'CASCADE');    

    }

    public function down()
    {
        echo "m141027_055344_gruppicontatti cannot be reverted.\n";

        return false;
    }
}
