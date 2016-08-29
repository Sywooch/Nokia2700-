<?php

namespace app\controllers;

use app\models\WidgetCatching;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\models\WidgetSettings;
use app\models\WidgetActionMarks;

class WidgetController extends Controller
{
    public function beforeAction($action)
    {
        $publicActions = [
            'location',
            'get-widget',
            'listener',
            'get-marks',
            'get-urls',
            'catched',
            'avgtime',
        ];
        if(in_array(Yii::$app->controller->action->id,$publicActions))
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionAvgtime()
    {
        $getArray = $getArray = Yii::$app->request->get();
        $query = new Query;
        $query->select('AVG(time),website')
            ->from('widget_catching')
            ->where('website="'.$getArray['site_url'].'" AND action="close_page"')
            ->groupBy('website');
        $row = $query->one();
        header('Access-Control-Allow-Origin: ' . $getArray['protocol'] . '//' . $getArray['site_url']);
        die($row['AVG(time)']);
    }

    public function actionCatched()
    {
        $getArray = $getArray = Yii::$app->request->get();
        $catch = new WidgetCatching();
        if(isset($getArray['key']))
        {
            $widget = WidgetSettings::find()->where("widget_key='".$getArray['key']."' AND widget_site_url='".$getArray['site_url']."'")->one();
            if(isset($widget)&&$widget->widget_status==1) {
                $catch->widget_id = $getArray['widget_id'];
            }
        }
        if (isset($getArray['ip']))
        {
            $catch->ip = $getArray['ip'];
        }
        else
        {
            $catch->ip = Yii::$app->request->getUserIP();
        }

        $catch->action = $getArray['event'];
        $catch->website = $getArray['site_url'];
        $catch->time = isset($getArray['time']) ? $getArray['time'] : 0;
        $catch->date = date('Y-m-d G:i:s');
        header('Access-Control-Allow-Origin: ' . $getArray['protocol'] . '//' . $getArray['site_url']);
        if($catch->save()) {
            die('ok');
        } else {
            die('error') ;
        }
    }

    public function actionLocation()
    {
        $getArray = $getArray = Yii::$app->request->get();
        $ip = $_SERVER["REMOTE_ADDR"];
        header('Access-Control-Allow-Origin: ' . $getArray['protocol'] . '//' . $getArray['site_url']);
        die($ip);
    }

    public function actionGetWidget()
    {
        $getArray = Yii::$app->request->get();
        if(isset($getArray['key']) && isset($getArray['site_url']) && isset($getArray['protocol']) && isset($getArray['template']))
        {
            $widget = WidgetSettings::find()->where("widget_key='".$getArray['key']."' AND widget_site_url='".$getArray['site_url']."'")->one();
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

                $widget_json['widget_site_url'] = $widget->widget_site_url;
                $widget_json['widget_button_color'] = $widget->widget_button_color;
                $widget_json['position'] = $widget->widget_position;
                $widget_json['widget_position_mobile'] = $widget->widget_position_mobile;
                $widget_json['theme_color'] = $widget->widget_theme_color;
                $widget_json['widget_settings'] = $widget->widget_settings;
                $widget_json['widget_goal'] = $widget->widget_name;
                $widget_json['widget_yandex_metrika'] = $widget->widget_yandex_metrika;
                $widget_json['widget_google_metrika'] = $widget->widget_google_metrika;
                $widget_json['widget_sound'] = $widget->widget_sound;
                $widget_json["social"] = $widget->social;
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
                    "today" => "Сегодня",
                    "tomorrow" => "Завтра",
                    "after-tomorrow" => "Послезавтра",
                    "work-start-time" => $time[date('l')]['start'],
                    "work-end-time" => $time[date('l')]['end'],
                    "day" => date('l'),
                    "time" => $time,
                    "gmt" => $widget->widget_GMT
                );
                $template = $getArray['template'] == 'desktop' ? 'WidGet.html' : 'WidGetMob.html';
                $widget_json['tmp'] = file_get_contents('../web/widget-front/'.$template);
                $widget_json['utp_img_url'] = $widget->utp_img_url;
                $widget_json['widget_utp_form_position'] = $widget->widget_utp_form_position;
                $widget_json['utp_img_url'] = $widget->utp_img_url;
                $widget_json['utm_button_color'] = $widget->utm_button_color;
                header('Access-Control-Allow-Origin: ' . $getArray['protocol'] . '//' . $widget->widget_site_url);
                //mb_convert_encoding($widget_json['date'],'UTF-8','UTF-8');
                die(json_encode($widget_json));
            } else {
                $error = ['status'=>'0','msg'=>'Виджет не найден','type'=>'user_is_missed'];
                die(json_encode($error));
            }
        }
    }

    public function actionGetMarks()
    {
        $getArray = Yii::$app->request->get();
        if(isset($getArray['key']) && isset($getArray['site_url']) && isset($getArray['protocol']))
        {
            $widget = WidgetSettings::find()->where("widget_key='".$getArray['key']."' AND widget_site_url='".$getArray['site_url']."'")->one();
            if(isset($widget)&&$widget->widget_status==1) {
                $marks = WidgetActionMarks::find()->where('widget_id='.$widget->widget_id)->one();

                $widget_json['other_page'] = $marks->other_page;
                $widget_json['scroll_down'] = $marks->scroll_down;
                $widget_json['active_more40'] = $marks->active_more40;
                $widget_json['mouse_intencivity'] = $marks->mouse_intencivity;
                //$widget_json['sitepage_activity'] = $marks->sitepage_activity;
                $widget_json['sitepage_activity'] = 0;
                $widget_json['sitepage3_activity'] = $marks->sitepage3_activity;
                $widget_json['more_avgtime'] = $marks->more_avgtime;
                $widget_json['moretime_after1min'] = $marks->moretime_after1min;
                $widget_json['form_activity'] = $marks->form_activity;
                $widget_json['client_activity'] = $marks->client_activity;

                header('Access-Control-Allow-Origin: ' . $getArray['protocol'] . '//' . $widget->widget_site_url);
                //mb_convert_encoding($widget_json['date'],'UTF-8','UTF-8');
                die(json_encode($widget_json));
            } else {
                $error = ['status'=>'0','msg'=>'Виджет не найден','type'=>'user_is_missed'];
                die(json_encode($error));
            }
        }
    }

    public function actionGetUrls()
    {
        $getArray = Yii::$app->request->get();
        if(isset($getArray['key']) && isset($getArray['site_url']) && isset($getArray['protocol']))
        {
            $widget = WidgetSettings::find()->where("widget_key='".$getArray['key']."' AND widget_site_url='".$getArray['site_url']."'")->one();
            if(isset($widget)&&$widget->widget_status==1) {
                $marks = WidgetActionMarks::find()->where('widget_id='.$widget->widget_id)->one();

                $pages = explode(';', $marks->site_pages_list);
                $count_pages = count($pages)-1;
                $page = [];
                for($i = 0; $i<$count_pages; $i++)
                {
                    $values = explode('*',$pages[$i]);
                    $page[$i]['url'] = $values[0];
                    $page[$i]['mark'] = $values[1];
                }
                $widget_json['success'] = true;
                $widget_json['pages'] = $page;
                header('Access-Control-Allow-Origin: ' . $getArray['protocol'] . '//' . $widget->widget_site_url);
                //mb_convert_encoding($widget_json['date'],'UTF-8','UTF-8');
                die(json_encode($widget_json));
            } else {
                $error = ['status'=>'0','msg'=>'Виджет не найден','type'=>'user_is_missed'];
                die(json_encode($error));
            }
        }
    }

    public function actionWidgetCall()
    {
        $getArray = Yii::$app->request->get();
        $key = $getArray['key'];
        $phone = $getArray['phone'];
        $event = $getArray['event'];
        $site_url = $getArray['site_url'];
        $widget = WidgetSettings::getJSONWidget($key, $site_url);
        $model = new WidgetSettings();
        if(is_array($widget) && $phone != 'undefined'){
            header('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
            die($model->widgetCall($phone, $event, $widget));
        } else throw new \Exception('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
    }

    public function actionWidgetMail()
    {
        $getArray = Yii::$app->request->get();
        $question = $getArray['question'];
        $phone = $getArray['phone'];
        $mail = $getArray['mail'];
        $key = $getArray['key'];
        $site_url = $getArray['site_url'];
        $widget = WidgetSettings::getJSONWidget($key, $site_url);
        $model = new WidgetSettings();
        if(is_array($widget) && $question != 'undefined' && $phone != 'undefined' && $mail != 'undefined'){
            header('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
            die($model->widgetMail($question, $phone, $mail, $widget));
        } else throw new \Exception('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
    }

    public function actionWidgetReview()
    {
        $getArray = Yii::$app->request->get();
        $key = $getArray['key'];
        $review = $getArray['review'];
        $starCount = $getArray['starCount'];
        $site_url = $getArray['site_url'];
        $callbackID = $getArray['callbackID'];
        $widget = WidgetSettings::getJSONWidget($key, $site_url);
        $model = new WidgetSettings();
        if(is_array($widget) && ($review != 'undefined' && $starCount != 'undefined' && $callbackID != 'undefined')){
            header('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
            die($model->widgetReview($review, $starCount, $callbackID, $widget));
        } else throw new \Exception('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
    }

    public function actionWidgetOrder()
    {
        $getArray = Yii::$app->request->get();
        $key = $getArray['key'];
        $phone = $getArray['phone'];
        $date = $getArray['date'];
        $time = $getArray['time'];
        $site_url = $getArray['site_url'];
        $widget = WidgetSettings::getJSONWidget($key, $site_url);
        $model = new WidgetSettings();
        if(is_array($widget) && ($phone != 'undefined' && $date != 'undefined' && $time != 'undefined')){
            header('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
            die($model->widgetOrder($phone, $date, $time, $site_url, $key, $widget));
        } else throw new \Exception('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
    }

    public function actionGetCallback()
    {
        $getArray = Yii::$app->request->get();
        $key = $getArray['key'];
        $site_url = $getArray['site_url'];
        $widget = WidgetSettings::getJSONWidget($key, $site_url);
        $model = new WidgetSettings();
        if(is_array($widget)){
            header('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
            die($model->widgetGetCallbackId($widget));
        } else throw new \Exception('Access-Control-Allow-Origin: '.$getArray['protocol'].'//'.$widget['widget_site_url']);
    }

    public function actionListener()
    {
        $getArray = Yii::$app->request->get();
        $model = new WidgetSettings();
        $model->getCallBackFollowmeCallInfo($getArray['event'], $getArray['id']);
    }
}