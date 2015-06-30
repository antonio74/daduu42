<?php

use yii\db\Schema;
use yii\db\Migration;

class m150117_164853_contact extends Migration
{
    public function up()
    {
    	$this->createTable('contact', [
            'id' => 'pk',
            'tenant_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'firstname' => Schema::TYPE_STRING . ' NOT NULL',
            'lastname' => Schema::TYPE_STRING . ' NOT NULL',
            'company' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'phone_prefix' => Schema::TYPE_STRING . ' NOT NULL',
            'phone' => Schema::TYPE_STRING . ' NOT NULL',
            'mobile_prefix' => Schema::TYPE_STRING . ' NOT NULL',
            'mobile' => Schema::TYPE_STRING . ' NOT NULL',
            'general_prefix' => Schema::TYPE_STRING . ' NOT NULL',
            'general' => Schema::TYPE_STRING . ' NOT NULL',
            'contact_category_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        $this->addForeignKey('FK_category', 'contact', 'contact_category_id', 'contact_category', 'id', 'CASCADE', 'NO ACTION');
    	$this->addForeignKey('FK_tenant', 'contact', 'tenant_id', 'tenant', 'id', 'CASCADE', 'NO ACTION');               
    }

    public function down()
    {
    	$this->dropTable('contact');
        echo "m150117_164853_contact was dropped.\n";
        return false;
    }
}
