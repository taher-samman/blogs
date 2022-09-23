<?php

namespace api\behaviors;

use Yii;
use yii\db\BaseActiveRecord;

class BlogImageBehavior extends \yii\behaviors\AttributeBehavior
{

    public $value = 'value';

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->value],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->value,
            ];
        }
    }

    protected function getValue($event)
    {
        if ($this->value === null) {
            return '';
        }
        $image_parts = explode(";base64,", $this->owner->value);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $image_name = uniqid() . '.' . str_replace('+xml', '', $image_type);
        $file = Yii::getAlias('uploads/blogs/' . $image_name);
        if (file_put_contents($file, $image_base64)) {
            return $image_name;
        }
        return '';
        // return parent::getValue($event);
    }
}
