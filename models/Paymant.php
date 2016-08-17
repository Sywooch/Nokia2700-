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
                    'partner_id'=>$rows['0']['partner'],
                    'client'=>$u_id,
                    'partner_of_partner'=>0,
                    'date'=> '',
                    'client_paid_sum'=>$sum,
                    'payment_for_part'=>$sum*0.3,
                    'type'=>0,
                    'description'=>'Партнер c ID-'.$rows['0']['partner'].' получил бонус 1-го порядка за своего клиента с ID-'.$u_id
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
                    'partner_id'=>$rows['0']['partner'],
                    'client'=>$partner_id,
                    'partner_of_partner'=>$u_id,
                    'date'=> '',
                    'client_paid_sum'=>$sum,
                    'payment_for_part'=>$sum*0.1,
                    'type'=>1,
                    'description'=>'Партнер c ID-'.$rows['0']['partner'].' получил бонус 2-го порядка за клиента с ID-'.$partner_id.' своего партнера с ID-'.$u_id
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
            foreach($bonus as $bon)
            {
                $row_to_save = new Bonus;
                $row_to_save->id='';
                $row_to_save->payment=$bon['payment_for_part'];
                $row_to_save->partner_id=$bon['partner_id'];
                $row_to_save->client=$bon['client'];
                $row_to_save->partner_of_partner=$bon['partner_of_partner'];
                $row_to_save->date='';
                $row_to_save->client_paid_sum=$bon['client_paid_sum'];
                $row_to_save->type=$bon['type'];
                $row_to_save->description=$bon['description'];
                $row_to_save->save();

                $bonus_hist = new BonusHistory;
                $bonus_hist->id='';
                $bonus_hist->payment=$bon['payment_for_part'];
                $bonus_hist->user_id=$bon['partner_id'];
                $bonus_hist->date='';
                $bonus_hist->order_num='in_bon_u_'.$bon['partner_id'].'_'.date('dmY');
                $bonus_hist->type=0;
                $bonus_hist->status=1;
                $bonus_hist->save();
            }

            return $bonus;
        }

    }

}