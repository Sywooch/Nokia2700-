<?php

namespace app\models;


use yii\db\ActiveRecord;

/**
* @property integer $user_id
* @property integer $request_id
* @property integer $request_message
* @property integer $request_sum
* @property integer $request_date
* @property string $request_status;
* @property integer $request_method
* @property integer $request_cart_id
*
**/

class PartnerCashRequest extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_cash_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'request_sum', 'request_method', 'request_cart_id', 'request_status'], 'required'],
            [['request_id', 'user_id', 'request_message', 'request_sum', 'request_status'], 'integer'],
            [['request_method','request_cart_id'], 'string'],
            [['request_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'request_id' => 'Номер счёта',
            'request_sum' => 'Сумма',
            'user_id' => 'Пользователь',
            'request_date' => 'Дата',
            'request_cart_id' => 'Номер счета',
            'request_message' => 'Тип',
            'typeFormat' => 'Тип',
            'dateFormat' => 'Дата',
            'payStatus' => 'Статус выполнения',
            'request_status' => 'Статус оплаты',
            'request_method' => 'Метод'
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

}