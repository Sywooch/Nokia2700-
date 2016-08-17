<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 15.08.2016
 * Time: 12:35
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\db\Query;

/**
* @property integer $id=
* @property integer $payment
* @property integer $partner_id
* @property integer $client
* @property integer $partner_of_partner
* @property string $date='';
* @property integer $client_paid_sum
* @property integer $type
* @property string $description

 * Class Bonus
 * @package app\models
 */
class Bonus extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_for_partners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'client', 'partner_of_partner', 'client_paid_sum', 'payment', 'description', 'type'], 'required'],
            [['id', 'partner_id', 'client', 'partner_of_partner', 'client_paid_sum', 'payment', 'type'], 'integer'],
            [['description'], 'string'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'partner_id' => 'Пользователь получающий бонус',
            'client' => 'Клиент пользователя получающего бонус',
            'partner_of_partner' => 'Пользователь получающий бонус 2-го уровня',
            'date' => 'Дата',
            'сдшуте_paid_sum'=>'Сума оплаты',
            'payment'=>'Сумма бонуса',
            'dateFormat' => 'Дата',
            'description'=> 'Описание',
            'type'=>'Тип бонуса'
        ];
    }


    public static function updateBonusses($u_id)
    {
        $query = new Query;
        $query->select('*')
            ->from('bonus_history')
            ->where("user_id='$u_id' AND status = 1");
        $finance = $query->all();



        $cache = 0;

        foreach ($finance as $fin)
        {
            ($fin['type'])? $cache -= $fin['payment']: $cache += $fin['payment'];
        }
        $mod = User::findOne($u_id);


        if (null != $mod ) {
            $mod->bonus = (integer)$cache;
            $mod->save();
        }

        return $mod;
    }
}