<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Query;

/**
 * This is the model class for table "tarifs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $tarif_name
 * @property integer $price
 * @property integer $minute_price
 * @property integer $sms_price
 * @property integer $published
 */
class Tarifs extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tarifs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tarif_name', 'price', 'minute_price', 'sms_price', 'published'], 'required'],
            [['id', 'price', 'minute_price', 'sms_price', 'published'], 'integer'],
            [['tarif_name'],'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'=>'id',
            'tarif_name'=>'Название тарифа',
            'price'=>'Абонентская плата',
            'minute_price'=>'Стоимость 1 минуты разговора',
            'sms_price'=>'стоимость 1 смс',
        ];
    }


    public static function setDefaultTarif($u_id)
    {
        $query = new Query;
        $query->select('*')
            ->from('user_tarif')
            ->where('user_id ="'.$u_id.'"');
        $u_tarif = $query->all();

        if($u_tarif == null)
        {
            $connection = Yii::$app->db->createCommand();
            $connection->insert('user_tarif',['user_id' => $u_id])->execute();
        }
    }

    public static function getUserTarif($u_id)
    {
        if(isset($u_id))
        {
            $query = new Query;
            $query->select('*')
                ->from('user_tarif')
                ->join('INNER JOIN', 'tarifs', 'tarifs.id=user_tarif.tarif_id')
                ->where('user_id="'.$u_id.'"');
            $rows = $query->all();
            return $rows;
        }
    }

    public static function getActiveTarifs()
    {
        $query = new Query;
        $query->select('*')
            ->from('tarifs')
            ->where('publised="1"');
        $rows = $query->all();
        return $rows;
    }

    public static function getArchiveTarifs()
    {
        $query = new Query;
        $query->select('*')
            ->from('tarifs')
            ->where('publised="0"');
        $rows = $query->all();
        return $rows;
    }

    public static function payForCall($call_duration, $widget_id)
    {
        $query_w = new Query();
        $query_w->select('widget_site_url, user_id')
            ->from('widget_settings')
            ->where("widget_id=$widget_id");
        $w_q = $query_w->all();

        $w_name = $w_q['0']['widget_site_url'];
        $u_id = $w_q['0']['user_id'];

        $query = new Query;
        $query->select('user_tarif.tarif_id, tarifs.*')
            ->from('user_tarif')
            ->join('INNER JOIN', 'tarifs','tarifs.id=user_tarif.tarif_id')
            ->where("user_id=$u_id");
        $rows = $query->all();

        if($rows['0']['minute_price'] != 0)
        {
            $row = $rows['0']['minute_price'];

            $price_for_call = $call_duration*$row;
            $order_num = 'call_with_'.$w_name;

            $hist = new PayHistory;
            $hist->id='';
            $hist->payment = (integer)$price_for_call;
            $hist->user_id = $u_id;
            $hist->date = '';
            $hist->order_num = $order_num;
            $hist->type = 1;
            $hist->status = 1;
            $hist->save();
            Paymant::renewCache($u_id);
            return $price_for_call;
        }
       else return self::payAbonement($widget_id);

    }

    public static function payForSMS($widget_id)
    {
        $query_w = new Query();
        $query_w->select('widget_site_url, user_id')
            ->from('widget_settings')
            ->where("widget_id=$widget_id");
        $w_q = $query_w->all();

        $w_name = $w_q['0']['widget_site_url'];
        $u_id = $w_q['0']['user_id'];

        $query = new Query;
        $query->select('user_tarif.tarif_id, tarifs.*')
            ->from('user_tarif')
            ->join('INNER JOIN', 'tarifs','tarifs.id=user_tarif.tarif_id')
            ->where("user_id=$u_id");
        $rows = $query->all();

        $row = $rows['0']['sms_price'];

        $price_for_call = $row;
        $order_num = 'sms_with_'.$w_name;

        $hist = new PayHistory;
        $hist->id='';
        $hist->payment = (integer)$price_for_call;
        $hist->user_id = $u_id;
        $hist->date = '';
        $hist->order_num = $order_num;
        $hist->type = 1;
        $hist->status = 1;
        $hist->save();
        Paymant::renewCache($u_id);
        return $hist;

    }

    public static function payAbonement($widget_id)
    {
        $query_w = new Query();
        $query_w->select('widget_site_url, user_id')
            ->from('widget_settings')
            ->where("widget_id=$widget_id");
        $w_q = $query_w->all();

        $w_name = $w_q['0']['widget_site_url'];
        $u_id = $w_q['0']['user_id'];

        $query = new Query;
        $query->select('user_tarif.tarif_id, tarifs.*')
            ->from('user_tarif')
            ->join('INNER JOIN', 'tarifs','tarifs.id=user_tarif.tarif_id')
            ->where("user_id=$u_id");
        $rows = $query->all();

        $row = $rows['0']['price'];

        $price_for_call = $row;
        $order_num = 'sms_with_'.$w_name;

        $hist = new PayHistory;
        $hist->id='';
        $hist->payment = (integer)$price_for_call;
        $hist->user_id = $u_id;
        $hist->date = '';
        $hist->order_num = $order_num;
        $hist->type = 1;
        $hist->status = 1;
        $hist->save();
        Paymant::renewCache($u_id);
        return $hist;

    }

}