<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "pay_history".
 *
 * @property integer $id
 * @property integer $payment
 * @property integer $user_id
 * @property string $date
 * @property integer $order_num
 * @property integer $type
 */
class PayHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment', 'user_id', 'order_num', 'type'], 'required'],
            [['payment', 'user_id', 'type', 'status'], 'integer'],
            ['order_num', 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер счёта',
            'payment' => 'Сумма',
            'user_id' => 'Пользователь',
            'date' => 'Дата',
            'order_num' => 'Номер заказа',
            'type' => 'Тип',
            'typeFormat' => 'Тип',
            'dateFormat' => 'Дата',
            'status' => 'Статус оплаты'
        ];
    }

    public function getTypeFormat()
    {
        return ($this->type==0) ? 'Пополнение' : 'Списание';
    }

    public function getPayStatus()
    {

        return ($this->status==1) ? 'Проведен' : 'Не проведен';
    }

    public function getDateFormat()
    {
        $date = new \DateTime($this->date);
        return $date->format('d.m.Y H:i:s');
    }

    public static function addHistoryPayment($payment, $email, $order_num)
    {
        $model = User::findByEmail(urldecode($email));
        $hist = new PayHistory;
        $hist->id='';
        $hist->payment = (integer)$payment;
        $hist->user_id = $model['user_id'];
        $hist->date = '';
        $hist->order_num = $order_num;
        $hist->type = (true)? 0 : 1;
        $hist->save();
        return $hist;
    }
}
