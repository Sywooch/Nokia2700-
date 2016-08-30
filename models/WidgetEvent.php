<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "widget_event".
 *
 * @property integer $id
 * @property string $event
 * @property string $callbackId
 */
class WidgetEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event', 'callbackId'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event' => 'Event',
            'callbackId' => 'Callback ID',
        ];
    }
}
