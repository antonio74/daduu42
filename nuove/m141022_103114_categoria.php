<?php

use yii\db\Schema;
use yii\db\Migration;

class m141022_103114_categoria extends Migration
{
    public function up()
    {
    	$this->createTable('categoria', [
            'id' => 'pk',
            'nome' => Schema::TYPE_STRING . ' NOT NULL',
            'descrizione' => Schema::TYPE_TEXT
        ]);
    }

    public function down()
    {
        echo "m141021_210820_categoria was dropped!!!.\n";
        $this->dropTable('categoria');
        return false;
    }
}
