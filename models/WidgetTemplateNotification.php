<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "widget_template_notification".
 *
 * @property integer $id_template
 * @property string $name
 * @property string $description
 * @property string $param
 */
class WidgetTemplateNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_template_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
            [['param'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_template' => 'Id Template',
            'name' => 'Name',
            'description' => 'Description',
            'param' => 'Param',
        ];
    }
}
