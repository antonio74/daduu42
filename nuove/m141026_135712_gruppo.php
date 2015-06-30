<?php

use yii\db\Schema;
use yii\db\Migration;

class m141026_135712_gruppo extends Migration
{
    public function up()
    {
    	$this->createTable('gruppo', [
            'id' => 'pk',
            'nome' => Schema::TYPE_STRING . ' NOT NULL',
            'descrizione' => Schema::TYPE_TEXT
        ]);
    }

    public function down()
    {
        echo "m141026_135712_gruppo cannot be reverted.\n";
        $this->dropTable('gruppo');
        return false;
    }
}
