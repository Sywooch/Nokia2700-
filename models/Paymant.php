<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 27.07.2016
 * Time: 17:52
 */

namespace app\models;


use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\validators\Validator;

/**
 * @param string $attribute the attribute currently being validated
 * @param mixed $params the value of the "params" given in the rule
 */

class Paymant extends Model
{

    public $summ;
    public $paywith;

    public $bonsum;
    public $bonpaywith;

    public $servicename;
    public $idinservise;

    public function rules()
    {
        return [
            [['summ'], 'required', 'message'=>'Ведите желаемую сумму оплаты.'],
            [['paywith'], 'required', 'message'=>'Выберите из списка сервис оплаты.'],
            [['servicename'], 'required', 'message'=>'Укажите сервис оплаты.'],
            [['bonpaywith'], 'required', 'message'=>'Выберите из списка желаемый способ получения.'],
            [['idinservise'], 'required', 'message'=>'Ведите номер кошелька на который перевести суму.'],
            [['bonsum'], 'required', 'message'=>'Ведите желаемую сумму.'],
            [['summ', ], 'double'],
            [['bonsum'], 'compare', 'compareValue' => Yii::$app->user->identity->bonus, 'operator' => '<', 'message'=>'Вееденная сума превышает остаток на бонусном счету'],
            [['paywith','bonpaywith','idinservise','servicename'], 'string'],
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

        if (null != $mod ) {
            $mod->cache = (integer)$cache;
            $mod->save();
        }
        self::cashNotification($user_id);

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

        if(isset ($rows['0']['partner'])) {
            if ($rows['0']['partner'] != 0) {
                $sum = $ceche;

                $payment_to_first_partner =
                    [
                        'partner_id' => $rows['0']['partner'],
                        'client' => $u_id,
                        'partner_of_partner' => 0,
                        'date' => '',
                        'client_paid_sum' => $sum,
                        'payment_for_part' => $sum * 0.3,
                        'type' => 0,
                        'description' => 'Бонус 1-го порядка за своего клиента с ID-' . $u_id
                    ];

                $payment_to_second_partner = self::cashForSecondPartners($rows['0']['partner'], $ceche, $u_id);

                $payment_to_partners ['payment_to_first_partner'] = $payment_to_first_partner;

                if ($payment_to_second_partner != 0) $payment_to_partners ['payment_to_second_partner'] = $payment_to_second_partner;


                return $payment_to_partners;
            } else return null;
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

        if(isset ($rows['0']['partner'])) {
            if ($rows['0']['partner'] != 0) {
                $sum = $ceche;

                $payment_to_second_partner =
                    [
                        'partner_id' => $rows['0']['partner'],
                        'client' => $partner_id,
                        'partner_of_partner' => $u_id,
                        'date' => '',
                        'client_paid_sum' => $sum,
                        'payment_for_part' => $sum * 0.1,
                        'type' => 1,
                        'description' => 'Бонус 2-го порядка за клиента партнера (ID-' . $partner_id . ') с ID-' . $u_id
                    ];

                return $payment_to_second_partner;
            } else {
                return 0;
            }
        }
        else return null;

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

    public function bonusValidate($attribute, $params)
    {
        if( $this->$attribute)
        {

            $this->addError($attribute, 'Вееденная сума превышает остаток на бонусном счету');
        }
    }

    public static function cashNotification($user_id)
    {
        $mod = User::findOne($user_id);
        if($mod->cache_notif_date != (string)date('dmY'))
        {
            $mod->cache_notif_status = 0;
            $mod->save();
        }
        else
        {
            return true;
        }
        if(null != $mod && $mod->cache_notif_status != 1)
        {
            $cash = $mod->cache;
            $query = new Query();
            $query->select('*')
                ->from('user_notif_settings')
                ->where('user_id="'.$user_id.'" AND notification_id=1');
            $row = $query->all();

//            return $row['0']['notification_value'];
            if ($row) {
                if($cash <=$row['0']['notification_value'] )
                {
                    if($row['0']['notification_email'] == 1 )
                    {

                        if(User::sendNotification($mod->email, $cash))
                        {
                            $mod->cache_notif_status = 1;
                            $mod->cache_notif_date = date('dmY');
                            $mod->save();
                        }
                    }
                }
            }
        }
    }
}