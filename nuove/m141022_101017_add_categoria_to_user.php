<?php

use yii\db\Schema;
use yii\db\Migration;

class m141022_101017_add_categoria_to_user extends Migration
{
    public function up()
    {
    	$this->execute('ALTER TABLE newrubrica ADD column id_categoria int(11) NOT NULL;');
    	$this->execute('ALTER TABLE newrubrica ADD FOREIGN KEY (id_categoria) REFERENCES categoria(id);');
    }

    public function down()
    {
        echo "m141022_101017_add_categoria_to_user cannot be reverted.\n";

        return false;
    }
}
