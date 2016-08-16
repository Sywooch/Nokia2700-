<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 27.07.2016
 * Time: 17:52
 */

namespace app\models;


use yii\base\Model;
use yii\db\Query;

class Paymant extends Model
{

    public $summ;
    public $paywith;

    public function rules()
    {
        return [
            ['summ', 'required', 'message'=>'Ведите желаемую сумму оплаты.'],
            ['paywith', 'required', 'message'=>'Выберите из списка сервис оплаты.'],
            /*['user_id', 'required', 'message'=>'Ведите желаемую сумму оплаты.'],*/
            ['summ', 'double'],
            ['paywith', 'string'],
            /*['user_id', 'integer'],*/
        ];
    }

    public static function renewCache($user_id)
    {
        $query = new Query;
        $query->select('*')
            ->from('pay_history')
            ->where("user_id='$user_id' AND status = 1");
        $finance = $query->all();



        $cache = 0;

        foreach ($finance as $fin)
        {
            ($fin['type'])? $cache -= $fin['payment']: $cache += $fin['payment'];
        }
        $mod = User::findOne($user_id);
        if($cache <= $mod->cache_notification && $mod->cache_notif_status != 1)
        {
            User::sendNotification($mod->email, $cache);
            $mod->cache_notif_status = 1;
            $mod->save();
        }
        else
        {
            $mod->cache_notif_status = 0;
            $mod->save();
        }

        if (null != $mod ) {
            $mod->cache = (integer)$cache;
            $mod->save();
        }

        return $mod;
    }

    protected static function cashForFirstPartners($u_id, $ceche)
    {
        $query = new Query;
        $query->select('*')
            ->from('users')
            ->where('user_id = "'.$u_id.'" AND partner != 0');
        /*WHERE MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())*/
        $rows = $query->all();

        if($rows['0']['partner'] != 0)
        {
            $sum = $ceche;

            $payment_to_first_partner =
                [
                    'user_id'=>$rows['0']['partner'],
                    'partner'=>$u_id,
                    'date'=> '',
                    'first_partn_paid_sum'=>$sum,
                    'paymant_for_first_part'=>$sum*0.3,
                    'description'=>'Начисление бонуса 1-го порядка'
                ];

            $payment_to_second_partner = self::cashForSecondPartners($rows['0']['partner'], $ceche, $u_id);

            $payment_to_partners ['payment_to_first_partner']=$payment_to_first_partner;

            if($payment_to_second_partner != 0) $payment_to_partners ['payment_to_second_partner']=$payment_to_second_partner;


            return $payment_to_partners;
        }
        else return null;

    }

    protected static function cashForSecondPartners($u_id, $ceche, $partner_id)
    {
        $query = new Query;
        $query->select('*')
            ->from('users')
            ->where('user_id = "'.$u_id.'" AND partner != 0');
        /*WHERE MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())*/
        $rows = $query->all();


        if($rows['0']['partner'] != 0)
        {
            $sum = $ceche;

            $payment_to_second_partner =
                [
                    'user_id'=>$rows['0']['partner'],
                    'partner_of_partner'=>$partner_id,
                    'partner'=>$u_id,
                    'date'=> '',
                    'first_partn_paid_sum'=>$sum,
                    'paymant_for_second_part'=>$sum*0.1,
                    'description'=>'Начисление бонуса 2-го порядка'
                ];

            return $payment_to_second_partner;
        }
        else
        {
            return 0;
        }

    }

    public static function saveBonus($u_id, $ceche)
    {
        $bonus = self::cashForFirstPartners($u_id, $ceche);
        if(isset($bonus))
        {
            
        }
    }

}