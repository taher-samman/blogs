<?php

namespace common\models;

use common\behaviors\BlogSlugBehavior;
use common\behaviors\BlogStatusBehavior;
use yii\db\ActiveRecord;

class Blogs extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%blogs}}';
    }

    // public function rules()
    // {
    //     return [
    //         // [['name', 'description', 'slug'], 'required']
    //     ];
    // }
    public function behaviors()
    {
        return [
            [
                'class' => BlogStatusBehavior::class,
                'enabled' => 'enabled'
            ],
            [
                'class' => BlogSlugBehavior::class,
                'slug' => 'slug'
            ],
        ];
    }
}
