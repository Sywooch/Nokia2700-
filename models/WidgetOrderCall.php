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
            [['widget_id', 'date', 'time', 'phone'], 'required'],
            [['widget_id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['phone'], 'string', 'max' => 24],
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
        ];
    }
}
