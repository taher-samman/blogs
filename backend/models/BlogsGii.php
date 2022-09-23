<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blogs".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property string $slug
 * @property string|null $description
 * @property int|null $cat_id
 * @property int|null $enabled
 *
 * @property BlogsImages[] $blogsImages
 * @property Categories $cat
 * @property Comments[] $comments
 * @property Likes[] $likes
 * @property User $user
 * @property User[] $users
 */
class BlogsGii extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'cat_id', 'enabled'], 'integer'],
            [['slug'], 'required'],
            [['name', 'slug', 'description'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['cat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'cat_id' => 'Cat ID',
            'enabled' => 'Enabled',
        ];
    }

    /**
     * Gets query for [[BlogsImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogsImages()
    {
        return $this->hasMany(BlogsImages::class, ['blog_id' => 'id']);
    }

    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::class, ['id' => 'cat_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['blog_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['blog_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('likes', ['blog_id' => 'id']);
    }
}
