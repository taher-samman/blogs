<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\CreatedAtBehavior;

class Likes extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%likes}}';
    }
    public function behaviors()
    {
        return [
            [
                'class' => CreatedAtBehavior::class,
            ]
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function fields()
    {
        return [
            'id',
            'user_id',
            'user' => function ($model) {
                return $model->user;
            }
        ];
    }
}
