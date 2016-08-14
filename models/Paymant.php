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
        if($cache <= $mod['cache_notification'] && $mod['cache_notif_status'] != 1)
        {
            User::sendNotification($mod['email'],$cache);
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
            return $mod;
        }
    }

    protected static function cashForFirstPartners($u_id)
    {
        $query = new Query;
        $query->select('*')
            ->from('users')
            ->where('partner = "'.$u_id.'"');
        /*WHERE MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())*/
        $rows = $query->all();

        $u_list = null;

            foreach($rows as $r)
            {
                $u_list .= 'user_id="'.$r['user_id'].'" OR ';
                self::cashForSecondPartners($r['user_id']);
            }
        $u_list = substr($u_list,0 , -4);


        $query_2 = new Query;
        $query_2->select('*')
            ->from('pay_history')
            ->where('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW()) AND '.$u_list.' AND type=0');
        //WHERE MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())
        $rows_2 = $query_2->all();
        $sum = 0;

        foreach($rows_2 as $rp)
        {
            $sum += $rp['paymant'];
        }

        $payment_for_month =
            [
                'user_id'=>$u_id,
                'date'=> date('F Y'),
                'count_first_referals'=>count($rows_2),
                'first_referals_paid_sum'=>$sum,
                'paymant_for_first_refer'=>$sum*0.3,
                'description'=>'Начисление за рефералов 1-го порядка'
            ];

        return $payment_for_month;
    }

    protected static function cashForSecondPartners($u_id)
    {
        $query = new Query;
        $query->select('*')
            ->from('users')
            ->where('partner = "'.$u_id.'"');
        /*WHERE MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())*/
        $rows = $query->all();

        $u_list = null;

        foreach($rows as $r)
        {
            $u_list .= 'user_id="'.$r['user_id'].'" OR ';
        }
        $u_list = substr($u_list,0 , -4);


        $query_2 = new Query;
        $query_2->select('*')
            ->from('pay_history')
            ->where('MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW()) AND '.$u_list.' AND type=0');
        //WHERE MONTH(`date`) = MONTH(NOW()) AND YEAR(`date`) = YEAR(NOW())
        $rows_2 = $query_2->all();

        $sum = 0;
        foreach($rows_2 as $rp)
        {
            $sum += $rp['paymant'];
        }

        $payment_for_month =
            [
                'user_id'=>$u_id,
                'date'=> date('F Y'),
                'count_second_referals'=>count($rows_2),
                'second_referals_paid_sum'=>$sum,
                'paymant_for_second_refer'=>$sum*0.1,
                'description'=>'Начисление за рефералов 2-го порядка'
            ];


        return $payment_for_month;
    }

    public static function cacheForPartners()
    {
        $query = new Query;
        $query->select('*')
            ->from('users')
            ->where('partner != "0"');
        $rows = $query->all();
        foreach($rows as $row)
        {
            self::cashForFirstPartners($row['user_id']);
        }

    }

}