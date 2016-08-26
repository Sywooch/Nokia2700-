<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 25.08.2016
 * Time: 15:12
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * @property integer $user_id
 * @property integer $notification_id
 * @property integer $notification_value
 * @property integer $notification_email
 * @property integer $notification_sms
 * @property string $notification_title
 */

class UserNotifSettings extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_notif_settings';
    }

    public function rules()
    {
        return [
            [['user_id', 'notification_id','notification_value','notification_email','notification_sms'], 'required'],
            [['user_id', 'notification_id','notification_value','notification_email','notification_sms'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'user_id' => 'Пользователь',
            'notification_id' => 'Оповещение',
            'notification_value' => 'Сумма/Значение оповещения',
            'typeFormat' => 'Тип',
            'notification_email' => 'Оповещение по email',
            'notification_sms' => 'Оповещение по смс',
        ];
    }

    public function getEmailNotif()
    {
        return ($this->notification_email==0) ? 'Подключить' : 'Отключить';
    }

    public function getSMSNotif()
    {
        return ($this->notification_sms==0) ? 'Подключить' : 'Отключить';
    }

    public static function findUserSettings($u_id)
    {
       $query = new Query();
        $query->select('*')
            ->from('user_notif_settings')
            ->join('INNER JOIN', 'user_notifications', 'user_notif_settings.notification_id = user_notifications.notification_id')
            ->where('user_id="'.$u_id.'"');
        $rows = $query->all();
        return $rows;

    }

    public static function setUserNotifSettings($u_id)
    {
            $query_2 = new Query;
            $query_2->select('*')
                ->from('user_notifications');
            $row = $query_2->all();

        foreach ($row as $r)
            {
                $sett = new UserNotifSettings();
                $sett->id = '';
                $sett->user_id=$u_id;
                $sett->notification_id = $r['notification_id'];
                $sett->notification_value='0';
                $sett->notification_email='1';
                $sett->notification_sms='0';
                $sett->save();
            }
        return self::findUserSettings($u_id);
    }

    public static function notification($user_id)
    {
        $mod = User::findOne($user_id);
        if(null != $mod && $mod->cache_notif_status != 1)
        {
            $cash = $mod->cache;
            $query = new Query();
            $query->select('*')
                ->from('user_notif_settings')
                ->where('user_id="'.$user_id.'" AND notification_id=1');
            $row = $query->all();

//            return $row['0']['notification_value'];

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