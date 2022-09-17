<?php

namespace common\models;

use yii\db\ActiveRecord;

class BlogsImages extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%blogs_images}}';
    }
}
