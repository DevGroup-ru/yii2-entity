<?php

use tests\models\Page;
use yii\db\Migration;

class m160616_084445_data extends Migration
{
    public function up()
    {
        $this->createTable(
            Page::tableName(),
            [
                'id' => $this->primaryKey(),
                'url' => $this->string(255)->notNull(),
                'slug' => $this->string(80)->notNull(),
                'title' => $this->string(255),
                'h1' => $this->string(255),
                'breadcrumbs_label' => $this->string(255),
                'meta_description' => $this->string(255),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            ''
        );
    }

    public function down()
    {
        $this->dropTable(Page::tableName());
    }
}
