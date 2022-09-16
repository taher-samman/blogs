<?php

use \yii\db\Migration;

class m190124_110201_add_verification_token_column_to_admin_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%admin}}', 'verification_token', $this->string()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%admin}}', 'verification_token');
    }
}
