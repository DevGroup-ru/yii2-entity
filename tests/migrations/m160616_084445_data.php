<?php

use tests\models\Page;
use tests\models\Slide;
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
                'deleted' => $this->integer()->notNull()->defaultValue(0),
            ],
            ''
        );
        $this->createTable(
            Slide::tableName(),
            [
                'id' => $this->primaryKey(),
                'src' => $this->string(255)->notNull(),
                'alt' => $this->string(255),
                'description' => $this->text(),
                'updated_by' => $this->integer(),
                'create_time' => $this->integer()->notNull(),
                'update_time' => $this->integer()->notNull(),
                'is_deleted' => $this->integer()->notNull()->defaultValue(0),
            ],
            ''
        );
    }

    public function down()
    {
        $this->dropTable(Slide::tableName());
        $this->dropTable(Page::tableName());
    }
}
