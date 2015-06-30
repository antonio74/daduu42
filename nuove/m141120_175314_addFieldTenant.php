<?php

use yii\db\Schema;
use yii\db\Migration;

class m141120_175314_addFieldTenant extends Migration
{
    public function up()
    {
    	$this->addColumn('user', 'id_tenant', "int(11) not null default '2'");
        $this->addForeignKey('FK_tenant', 'user', 'id_tenant', 'tenants', 'id', 'CASCADE', 'CASCADE');      	
    }

    public function down()
    {
        echo "m141120_175314_addFieldTenant cannot be reverted.\n";

        return false;
    }
}
