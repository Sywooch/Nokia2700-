<?php

namespace app\models;

use CURLFile;
use Yii;

/**
 * This is the model class for table "widget_settings".
 *
 * @property integer $widget_id
 * @property string $widget_key
 * @property integer $widget_status
 * @property string $widget_site_url
 * @property string $widget_user_email
 * @property string $widget_position
 * @property string $widget_position_mobile
 * @property string $widget_name
 * @property string $widget_button_color
 * @property string $widget_work_time
 * @property integer $widget_theme_color
 * @property integer $widget_yandex_metrika
 * @property integer $widget_google_metrika
 * @property string $black_list
 * @property string $widget_phone_number_1
 * @property string $widget_phone_number_2
 * @property string $widget_phone_number_3
 * @property string $widget_phone_number_4
 * @property string $widget_language
 * @property integer $user_id
 * @property string $widget_settings
 * @property integer $widget_GMT
 * @property integer $widget_callback_email
 * @property integer $widget_sound
 * @property string $widget_utp_form_position
 * @property string $utm_button_color
 * @property string $utp_img_url
 * @property integer hand_turn_on
 */
class WidgetSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['widget_key', 'widget_site_url', 'user_id', 'widget_work_time'], 'required'],
            [['widget_status', 'widget_theme_color', 'widget_yandex_metrika', 'widget_google_metrika', 'user_id', 'widget_GMT', 'widget_callback_email', 'widget_sound','hand_turn_on', 'utp_turn_on'], 'integer'],
            [['widget_settings', 'black_list'], 'string'],
            [['widget_key', 'widget_site_url', 'widget_user_email'], 'string', 'max' => 100],
            [['widget_position', 'widget_position_mobile'], 'string', 'max' => 150],
            [['widget_name'], 'string', 'max' => 80],
            [['widget_button_color', 'widget_phone_number_1', 'widget_phone_number_2', 'widget_phone_number_3', 'widget_phone_number_4', 'widget_language'], 'string', 'max' => 45],
            [['widget_phone_numbers'], 'string', 'max' => 150],
            [['widget_work_time', 'utp_img_url'], 'string', 'max' => 500],
            [['widget_utp_form_position', 'utm_button_color'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'widget_id' => 'Widget ID',
            'widget_key' => 'Widget Key',
            'widget_status' => 'Widget Status',
            'widget_site_url' => 'Widget Site Url',
            'widget_user_email' => 'Widget User Email',
            'widget_position' => 'Widget Position',
            'widget_position_mobile' => 'Widget Position Mobile',
            'widget_name' => 'Widget Name',
            'widget_button_color' => 'Widget Button Color',
            'widget_work_time' => 'Widget Work Time',
            'widget_theme_color' => 'Widget Theme Color',
            'widget_yandex_metrika' => 'Widget Yandex Metrika',
            'widget_google_metrika' => 'Widget Google Metrika',
            'widget_phone_numbers' => 'Phone Numbers',
            'widget_phone_number_1' => 'Widget Phone Number 1',
            'widget_phone_number_2' => 'Widget Phone Number 2',
            'widget_phone_number_3' => 'Widget Phone Number 3',
            'widget_phone_number_4' => 'Widget Phone Number 4',
            'widget_language' => 'Widget Language',
            'user_id' => 'User ID',
            'widget_settings' => 'Widget Settings',
            'widget_GMT' => 'Widget  Gmt',
            'widget_callback_email' => 'Widget Callback Email',
            'widget_sound' => 'Widget Sound',
            'widget_utp_form_position' => 'Widget Utp Form Position',
            'utm_button_color' => 'Utm Button Color',
            'utp_img_url' => 'Utp Img Url',
            'hand_turn_on' => 'Hand Turn On',
            'utp_turn_on' => 'UTP Turn On',
        ];
    }

    public function getUsers()
    {
        return $this
            ->hasOne(User::className(), ['user_id' => 'user_id'])       
            ->viaTable(User::tableName(), ['user_id' => 'user_id']);  
    }

    public static function checkSiteUsage($site, $key)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://".$site);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $pos = strpos($output,$key);
        if($pos === false) {
            return '<span style="color:red">Не установлен</span>';
        } else {
            return '<span style="color:green">Установлен</span>';
        }
    }

    public function getWidgetMessages()
    {
        return $this
            ->hasOne(WidgetSendedEmail::className(), ['widget_id' => 'widget_id'])       
            ->viaTable(WidgetSendedEmail::tableName(), ['widget_id' => 'widget_id']);  
    }

    public static function getCode($widget_code)
    {
        print '<textarea style="width: 100%; height: 370px;" readonly>
            <script type="text/javascript">
            (function (d, w) {
                var robax_widget="robax-"+'.$widget_code.';
                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    c = function () {w["robax_widget"+robax_widget]=new RobaxWidget({id:robax_widget,key:'.$widget_code.',w:w});},
                    f = function () {n.parentNode.insertBefore(s, n); d.getElementById(robax_widget).onload=c;};
                    s.id=robax_widget;
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = "//r.oblax.ru/widget-front/robax.js";
                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                } else { f(); }
            })(document, window);
            </script>
        </textarea>';
    }

    public static function getJSONWidget($key, $url)
    {
        $widget = WidgetSettings::find()->where("widget_key='".$key."' AND widget_site_url='".$url."'")->one();
        if(isset($widget)&&$widget->widget_status==1) {
            $time_cache = json_decode($widget->widget_work_time);

            $time['Monday']['start'] = $time_cache->monday->start;
            $time['Monday']['end'] = $time_cache->monday->end;
            $time['Monday']['lunch'] = $time_cache->monday->lunch;
            $time['Tuesday']['start'] = $time_cache->tuesday->start;
            $time['Tuesday']['end'] = $time_cache->tuesday->end;
            $time['Tuesday']['lunch'] = $time_cache->tuesday->lunch;
            $time['Wednesday']['start'] = $time_cache->wednesday->start;
            $time['Wednesday']['end'] = $time_cache->wednesday->end;
            $time['Wednesday']['lunch'] = $time_cache->wednesday->lunch;
            $time['Thursday']['start'] = $time_cache->thursday->start;
            $time['Thursday']['end'] = $time_cache->thursday->end;
            $time['Thursday']['lunch'] = $time_cache->thursday->lunch;
            $time['Friday']['start'] = $time_cache->friday->start;
            $time['Friday']['end'] = $time_cache->friday->end;
            $time['Friday']['lunch'] = $time_cache->friday->lunch;
            $time['Saturday']['start'] = $time_cache->saturday->start;
            $time['Saturday']['end'] = $time_cache->saturday->end;
            $time['Saturday']['lunch'] = $time_cache->saturday->lunch;
            $time['Sunday']['start'] = $time_cache->sunday->start;
            $time['Sunday']['end'] = $time_cache->sunday->end;
            $time['Sunday']['lunch'] = $time_cache->sunday->lunch;

            $widget_json['widget_id'] = $widget->widget_id;
            $widget_json['widget_site_url'] = $widget->widget_site_url;
            $widget_json['user_id'] = $widget->user_id;
            $widget_json['position'] = $widget->widget_position;
            $widget_json['position_mobile'] = $widget->widget_position_mobile;
            $widget_json['theme_color'] = $widget->widget_theme_color;
            $widget_json['widget_settings'] = $widget->widget_settings;
            $widget_json["buttons"] = array(
                "post" => "Жду звонка!",
                "post-form" => "Отправить"
            );
            $widget_json['menu'] = array(
                "phone-text" => "Звонок",
                "msg-text" => "Диалог",
                "mail-text" => "Письмо"
            );
            $widget_json['phone'] = array(
                "h1" => "— Я тут заметил,",
                "item-text" => "что вы внимательно ищете может подсказать что-нибудь и сразу обсудить цену для вас? _",
                "phone-type" => array(
                    "ru" => "Россия <span>+7</span>",
                    "by" => "Беларусь <span>+375</span>",
                    "ua" => "Украина <span>+380</span>",
                    "us" => "США <span>+1</span>"
                ),
                "later-text" => "Выбрать удобное время звонка",
                "now-text" => "Позвонить сейчас"
            );
            $widget_json['widget-msg'] = array(
                "h1" => "— Упс,",
                "item-text" => "сейчас в офисе ни души. Закажем на завтра обратный звонок или напишем письмо? _",
                "msg-body" => array(
                    array(
                        "step-name" => "first",
                        "body" => "Some text",
                        "buttons" => array(
                            array(
                                "text" => "Закажем звонок",
                                "step-name" => "phone"
                            ),
                            array(
                                "text" => "Напишем письмо",
                                "step-name" => "mail"
                            ),
                            array(
                                "text" => "Хочу поболтать",
                                "step-name" => "step-too"
                            )
                        )
                    )
                )
            );
            $widget_json['mail'] = array(
                "h1" => "— Сейчас сотрудники",
                "item-text" => "не в офисе. Но в выбранное время Вам перезвонят. _"
            );
            $widget_json['date'] = array(
                "today" => "сегодня",
                "tomorrow" => "завтра",
                "after-tomorrow" => "послезавтра",
                "work-start-time" => $time[date('l')]['start'],
                "work-end-time" => $time[date('l')]['end'],
                "gmt" => $widget->widget_GMT
            );
            $phones = explode(';', $widget->widget_phone_numbers);
            $num = count($phones) - 1;
            unset($phones[$num]);
            $count_phones = count($phones);
            for ($i = 1; $i <= $count_phones; $i++)
            {
                $widget_json['widget_phone_number_'.$i] = $phones[$i-1];
            }
            $widget_json['tmp'] = file_get_contents('../web/widget-front/WidGet.html');
            $widget_json['utp_img_url'] = $widget->utp_img_url;
            $widget_json['widget_utp_form_position'] = $widget->widget_utp_form_position;
            $widget_json['utp_img_url'] = $widget->utp_img_url;
            $widget_json['hand_turn_on'] = $widget->hand_turn_on;
            $widget_json['utp_turn_on'] = $widget->utp_turn_on;
            $widget_json['utm_button_color'] = $widget->utm_button_color;
            return $widget_json;
        } else return false;
    }

    public function widgetCall($key,$url,$phone, $megaEvent)
    {
        $widget=$this->getJSONWidget($key,$url);
        if(is_array($widget)){
            $callback=$this->makeCallBackCallFollowMe($widget,$this->cutNumber($phone),$url, $megaEvent);
            if($callback){
                //all is good
            } else {
                //all is shit
            }
            return true;
        } else return 'error';/*$this->error['widget_not_found'];*/
    }

    public function makeCallBackCallFollowMe($widget, $phone, $url, $megaEvent)
    {
        if($this->checkCallbackBalance($widget['user_id'])){

            $customer_name = '883140779001066';
            //Получаем списки номеров клиента в настройках виджета
            $data['simpleCallBackFollowmeStruct'] = [];
            $order_count = 1;
            for ($i = 1; $i < 5; $i++)
            {
                if (isset($widget['widget_phone_number_'.$i]) && $widget['widget_phone_number_'.$i] != '')
                {
                    $data['simpleCallBackFollowmeStruct'][] = [
                        "order" => $order_count,
                        "timeout" => 40,
                        "redirect_number" => $this->cutNumber($widget['widget_phone_number_'.$i]),
                        //"redirect_number" => '+74993227920',
                        "type" => "lineral",
                        "name" => "manager_".$i
                    ];
                    $order_count++;
                }
            }
            /*
                        $data['simpleCallBackFollowmeStruct'][] = [
                            "order": $order_count,
                            "type": "text",
                            "value": "Звонок с сайта все продам ру",
                            "side": "A"
                            ];
            */
            $response = $this->mttCallBackAPI(array(
                "id" => "1",
                "jsonrpc" => "2.0",
                "method" => "makeCallBackCallFollowme",
                "params" => array(
                    "customer_name"=> $customer_name,
                    "b_number" => '+'.$this->cutNumber($phone),
                    "callBackURL" => "r.oblax.ru/widget/listener",
                    //"caller_id" => "+74993227920",
                    "caller_id" => $this->cutNumber($data['simpleCallBackFollowmeStruct'][0]['redirect_number']),
                    "recordEnable" => "1",
                    //"client_caller_id" => "+7xxxxxxxxxx",
                    //структура, которую необходимо сформировать при звонке,
                    //для этого необходимо получить все номера телефонов
                    "simpleCallBackFollowmeStruct" => $data['simpleCallBackFollowmeStruct']
                )
            ));
            if (!is_bool($response)){
                if(isset($response->result->callBackCall_id)){
                    $callBackCall_id = $response->result->callBackCall_id;
                    $this->saveCall($widget['widget_id'],$phone,$callBackCall_id,1, $megaEvent);
                }
            }
            return true;
        } else {
            //Баланс < 10 рублей отправляем заявку на звонок
            return false;
        }
    }

    public function getCallBackFollowmeCallInfo($end_side,$callBackCall_id)
    {
        $customer = '883140779001066';
        $response = $this->mttCallBackAPI(array(
            "id" => "1",
            "jsonrpc" => "2.0",
            "method" => "getCallBackFollowmeCallInfo",
            "params" => array(
                "customer_name"=> $customer,
                'callBackCall_id' => $callBackCall_id
            )
        ));
        if(isset($response->error))
        {
            $model = WidgetPendingCalls::find()->where('callBackCall_id="'.$callBackCall_id.'"')->one();
            $model->end_side = $response->error->data;
            $model->save();
        }
        if (!is_bool($response)){
            if(isset($response->result->callBackFollowmeCallInfoStruct)){
                $length = $response->result->callBackFollowmeCallInfoStruct->call_back_real_length_B;
                $minutes = round($length/60,0);
                $seconds = ($length%60 > 0 && $length%60 < 30) ? 1 : 0;
                $model = WidgetPendingCalls::find()->where('callBackCall_id="'.$callBackCall_id.'"')->one();
                $model->end_side = $end_side;
                $model->call_back_cost = Tarifs::payForCall($minutes+$seconds, $model->widget_id);
//                $user = User::find()->join('INNER JOIN','widget_settings','widget_settings.user_id=users.user_id')->where('widget_settings.widget_id='.$model->widget_id)->one();
//                $user->cache -= $model->call_back_cost;
//                $user->save();
                $model->call_back_currency = $response->result->callBackFollowmeCallInfoStruct->call_back_currency;
                $model->waiting_period_A = $response->result->callBackFollowmeCallInfoStruct->waiting_period_A;
                $model->waiting_period_B = $response->result->callBackFollowmeCallInfoStruct->waiting_period_B;
                $model->call_back_real_length_A = $response->result->callBackFollowmeCallInfoStruct->call_back_real_length_A;
                $model->call_back_real_length_B = $response->result->callBackFollowmeCallInfoStruct->call_back_real_length_B;
                $model->call_back_admin_cost = $response->result->callBackFollowmeCallInfoStruct->call_back_cost;
                $model->call_back_record_URL_A = $response->result->callBackFollowmeCallInfoStruct->call_back_record_URL_A;
                $model->call_back_record_URL_B = $response->result->callBackFollowmeCallInfoStruct->call_back_record_URL_B;
                $model->save();

                $subject = 'Уведомление об успешно звонке Robaks!';
                $message =
                    '<html>
                        <head>
                            <title>Соверщён успешный звонок!</title>
                        </head>
                        <body>
                            <p>'.$model->end_side.'</p>
                        </body>
                    </html>';
                Yii::$app->mailer->compose()
                    ->setTo($model->widget_user_email_1)
                    ->setFrom('robax@oblax.ru')
                    ->setSubject($subject)
                    ->setHtmlBody($message)
                    ->send();
            }
        }
    }

    public function checkCallbackBalance($user_id)
    {
        $user = User::findOne($user_id);
        if($user->cache > 0)
        {
            return true;
        }
        return false;
    }

    public function mttCallBackAPI($data)
    {
        $config = $this->initConfig();
        $id = 1;
        echo json_encode($data);
        if ($mtt_curl = curl_init())
        {
            curl_setopt($mtt_curl, CURLOPT_URL, $config['url']);                          //устанавливает адрес обращения для curl
            curl_setopt($mtt_curl, CURLOPT_USERPWD, $config['username'] . ':' . $config['password']);     //задает логин и пароль
            curl_setopt($mtt_curl, CURLOPT_POST, 1);                            //устанавливаем в качестве передачи донных метод post
            curl_setopt($mtt_curl, CURLOPT_RETURNTRANSFER, 1);                  //устанавливаем флаг для получения результата
            curl_setopt($mtt_curl, CURLOPT_SSL_VERIFYPEER, false);              //устанавливаем флаг "не проверять сертификаты ssl и принимать их"
            curl_setopt($mtt_curl, CURLOPT_POSTFIELDS, json_encode($data));             //преобразуем массив в json и задаем поля для post запроса
            $response = json_decode(curl_exec($mtt_curl));                           //отправляем запрос, преобразуем json в php-объект
            if ($response === null){
                //если результат равен null то значит произошла ошибка, выбрасываем исключение
                return false;
            }else{
                return $response;
            }
        } else {
            //если не удалось проинициализировать curl выбрасываем исключения
            return false;
        }
    }

    public function initConfig()
    {
        return [
            'url' => 'https://webapicommon.mtt.ru/index.php',
            'username' => 'CallBack_16',
            'password' => 'jexEy4phu6RezecH'
        ];
    }

    public function saveCall($w_id,$phone,$callBackCall_id,$status, $megaEvent)
    {
        $model = new WidgetPendingCalls();
        $model->widget_id = $w_id;
        $model->phone = $phone;
        $model->status = $status;
        $model->callBackCall_id = $callBackCall_id;
        $model->catching_event = $megaEvent;
        $model->save();
    }

    public function cutNumber($number)
    {
        $array = ['(',')','-',' '];
        return str_replace($array, "", $number);
    }
}