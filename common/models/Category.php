<?php

namespace common\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%categories}}';
    }
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['sort', 'parent'], 'integer']
        ];
    }
}
