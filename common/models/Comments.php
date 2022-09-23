<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\CreatedAtBehavior;

class Comments extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%comments}}';
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
            'blog_id',
            'comment',
            'created_at',
            'user' => function ($model) {
                return $model->user;
            }
        ];
    }
}
