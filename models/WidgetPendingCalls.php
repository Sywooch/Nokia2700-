<?php

namespace app\models;

use Yii;
use \yii\db\Query;

/**
 * This is the model class for table "widget_pending_calls".
 *
 * @property integer $widget_id
 * @property integer $id
 * @property string $call_time
 * @property string $phone
 * @property integer $status
 * @property string $callBackCall_id
 * @property string $end_side
 * @property double $call_back_cost
 * @property integer $record_status
 * @property integer $waiting_period_A
 * @property integer $waiting_period_B
 * @property integer $call_back_real_length_A
 * @property integer $call_back_real_length_B
 * @property double $call_back_admin_cost
 * @property string $call_back_currency
 * @property string $test_info
 */
class WidgetPendingCalls extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_pending_calls';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_id', 'phone', 'status', 'callBackCall_id'], 'required'],
            [['widget_id', 'status', 'record_status', 'call_back_real_length_A', 'call_back_real_length_B', 'waiting_period_B', 'waiting_period_A'], 'integer'],
            [['call_time'], 'safe'],
            [['call_back_cost' , 'call_back_admin_cost'], 'number'],
            [['test_info'], 'string'],
            [['phone'], 'string', 'max' => 45],
            [['callBackCall_id'], 'string', 'max' => 150],
            [['end_side'], 'string', 'max' => 50],
            [['call_back_record_URL_A', 'call_back_record_URL_B'], 'string', 'max' => 255],
            [['call_back_currency'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'widget_id' => 'Номер виджета',
            'id' => 'ID',
            'call_time' => 'Дата звонка',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'callBackCall_id' => 'Call Back Call ID',
            'end_side' => 'Окончившая сторона',
            'EndSide' => 'Окончившая сторона',
            'call_back_cost' => 'Сумма',
            'record_status' => 'Record Status',
            'test_info' => 'Test Info',
            'waiting_period_A' => 'Время ожидания абонента А',
            'waiting_period_B' => 'Время ожидания абонента Б',
        ];
    }

    public function getWidget()
    {
        return $this
            ->hasOne(WidgetSettings::className(), ['widget_id' => 'widget_id'])       
            ->viaTable(WidgetSettings::tableName(), ['widget_id' => 'widget_id']);  
    }

    public function getEndSide()
    {
        switch($this->end_side)
        {
            case 'end_side_A':
                return 'Сторона А';
                break;
            case 'end_side_B':
                return 'Сторона Б';
                break;
            case 'Call ended by cancel on side A':
                return 'Абонент А не поднял трубку';
                break;
            case 'Call ended by cancel on side B':
                return 'Абонент Б не поднял трубку';
                break;
            default:
                return 'Звонок не состоялся';
                break;
        }
    }

    public static function getCountRequireCalls()
    {
        $query = new Query;
        $query->select('*')
            ->from('widget_pending_calls');
        $row = $query->count();
        return $row;
    }
}
