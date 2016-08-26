<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "widget_order_call".
 *
 * @property integer $id
 * @property integer $widget_id
 * @property string $date
 * @property string $time
 * @property string $phone
 * @property string $url
 * @property string $key
 * @property boolean $status
 */
class WidgetOrderCall extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_order_call';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'date', 'time', 'phone', 'url', 'key'], 'required'],
            [['widget_id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['status'], 'boolean'],
            [['phone'], 'string', 'max' => 24],
            [['url'], 'string', 'max' => 64],
            [['key'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'widget_id' => 'Widget ID',
            'date' => 'Date',
            'time' => 'Time',
            'phone' => 'Phone',
            'url' => 'Url',
            'key' => 'Key',
            'status' => 'Status',
        ];
    }
}
