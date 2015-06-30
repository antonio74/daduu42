<?php

use yii\db\Schema;
use yii\db\Migration;

class m150117_171612_contact_to_contact_group extends Migration
{
    public function up()
    {
    	$this->createTable('contact_to_contact_group', [
            'contact_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'contact_group_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'PRIMARY KEY (contact_id, contact_group_id)',

        ]);
        $this->addForeignKey('FK_contact', 'contact_to_contact_group', 'contact_id', 'contact', 'id', 'CASCADE', 'NO ACTION');
    	$this->addForeignKey('FK_contact_group', 'contact_to_contact_group', 'contact_group_id', 'contact_group', 'id', 'CASCADE', 'NO ACTION');
    }

    public function down()
    {
    	$this->dropTable('contact_to_contact_group');    	
        echo "m150117_171612_contact_to_contact_group was dropped.\n";

        return false;
    }
}
