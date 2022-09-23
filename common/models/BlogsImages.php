<?php

namespace common\models;

use api\behaviors\BlogImageBehavior;
use yii\db\ActiveRecord;

class BlogsImages extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%blogs_images}}';
    }
    public function behaviors()
    {
        return [
            [
                'class' => BlogImageBehavior::class,
                'value' => 'value'
            ],
        ];
    }
}
