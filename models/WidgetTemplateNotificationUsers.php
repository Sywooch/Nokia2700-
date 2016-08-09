<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "widget_template_notification_users".
 *
 * @property integer $id_notification
 * @property integer $id_user
 * @property integer $id_template
 * @property string $description
 * @property string $param
 * @property boolean $default_template
 */
class WidgetTemplateNotificationUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_template_notification_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_template'], 'required'],
            [['id_user', 'id_template'], 'integer'],
            [['default_template'], 'boolean'],
            [['description'], 'string', 'max' => 255],
            [['param'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_notification' => 'Id Notification',
            'id_user' => 'Id User',
            'id_template' => 'Id Template',
            'description' => 'Description',
            'param' => 'Param',
            'default_template' => 'Default Template',
        ];
    }
}
