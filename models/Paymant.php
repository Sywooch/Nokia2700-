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

        if (($model = User::findOne($user_id)) !== null) {
            $model->cache = $cache;
            $model->update();
        }
    }

}