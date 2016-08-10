<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "widget_template_notification_users".
 *
 * @property integer $id_notification
 * @property integer $id_widget
 * @property integer $id_template
 * @property string $description
 * @property string $param
 * @property boolean $status
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
            [['id_widget', 'id_template'], 'required'],
            [['id_widget', 'id_template'], 'integer'],
            [['status'], 'boolean'],
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
            'id_widget' => 'Id Widget',
            'id_template' => 'Id Template',
            'description' => 'Description',
            'param' => 'Param',
            'status' => 'Status',
        ];
    }
}
