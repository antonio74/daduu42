<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_123909_add_tenant_id_to_user extends Migration
{
    public function up()
    {
    	$this->addColumn('user', 'tenant_id', "int(11) not null");
        $this->addForeignKey('FK_tenant_id', 'user', 'tenant_id', 'tenant', 'id', 'CASCADE', 'CASCADE');   
    }

    public function down()
    {
        echo "m150119_123909_add_tenant_id_to_user cannot be reverted.\n";

        return false;
    }
}
