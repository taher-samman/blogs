<?php

namespace common\models;

use common\behaviors\BlogSlugBehavior;
use common\behaviors\BlogStatusBehavior;
use Yii;
use yii\behaviors\CreatedAtBehavior;
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
            [
                'class' => CreatedAtBehavior::class,
            ]
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getBlogsImages()
    {
        return $this->hasMany(BlogsImages::class, ['blog_id' => 'id']);
    }
    public function getCat()
    {
        return $this->hasOne(Category::class, ['id' => 'cat_id']);
    }
    public function fields()
    {
        return [
            'id',
            'user_id',
            'user' => function ($model) {
                return $model->user;
            },
            'name',
            'description',
            'cat_id',
            'cat_name' => function ($model) {
                return $model->cat->name;
            },
            'images' => function ($model) {
                $result = [];
                foreach ($model->blogsImages as $key => $value) {
                    $result[$value->id] = Yii::getAlias('@apiimages') . '/blogs/' . $value->value;
                }
                return $result;
            },
            'created_at',
            'updated_at'
        ];
    }
}
