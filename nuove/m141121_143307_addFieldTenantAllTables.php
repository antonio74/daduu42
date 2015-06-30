<?php

use yii\db\Schema;
use yii\db\Migration;

class m141121_143307_addFieldTenantAllTables extends Migration
{
    public function up()
    {
    	$this->addColumn('newrubrica', 'id_tenant', "int(11) not null default '2'");
        $this->addForeignKey('FK_newrubricaTenant', 'newrubrica', 'id_tenant', 'tenants', 'id', 'CASCADE', 'CASCADE');      	
    	$this->addColumn('categoria', 'id_tenant', "int(11) not null default '2'");
        $this->addForeignKey('FK_categoriaTenant', 'categoria', 'id_tenant', 'tenants', 'id', 'CASCADE', 'CASCADE');      	
    	$this->addColumn('gruppo', 'id_tenant', "int(11) not null default '2'");
        $this->addForeignKey('FK_gruppoTenant', 'gruppo', 'id_tenant', 'tenants', 'id', 'CASCADE', 'CASCADE');      	
    }

    public function down()
    {
        echo "m141121_143307_addFieldTenantAllTables cannot be reverted.\n";

        return false;
    }
}
