<?php

namespace app\controllers;

use app\models\Bonus;
use app\models\BonusHistory;
use app\models\Paymant;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Connection;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\PayHistory;
use app\models\WidgetSendedEmail;
use app\models\WidgetPendingCalls;
use app\models\WidgetSettings;
use app\models\WidgetActionMarks;
use app\models\WidgetTemplateNotification;
use app\models\WidgetTemplateNotificationUsers;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public $publicActions = [];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index', 'pay', 'pay-history',
                            'analytics', 'savesiteimage',
                            'widgets', 'history', 'add-widget',
                            'update-widget',
                            'pay-with', 'paid', 'fail','paid-ik',
                            'update-paid-ik', 'tarifs', 'sound',
                            'user-tarif', 'for-test', 'deletewidget',
                            'update-user'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            Paymant::renewCache(Yii::$app->user->id);
            Bonus::updateBonusses(Yii::$app->user->id);
        }

        $this->enableCsrfValidation = false;
        $this->layout = "@app/views/layouts/profile";
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $widgetSettings = WidgetSettings::find()->where(['user_id' => Yii::$app->user->id])->count();
        return $this->render('index', ['widgetSettings' => $widgetSettings]);
    }

    public function actionForTest()
    {
        return $this->render('for-test');
    }

    public function actionTarifs()
    {
        return $this->render('tarifs');
    }

    public function actionAnalytics()
    {
        return $this->render('analytics');
    }

    public function actionPay()
    {
        return $this->render('pay');
    }

    public function actionPaid()
    {
        return $this->render('paid');
    }
    public function actionPaidIk()
    {
        return $this->render('paid-ik');
    }

    public function actionFail()
    {
        return $this->render('fail');
    }

    public function actionPayHistory()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PayHistory::find()->where('user_id='.Yii::$app->user->identity->id),
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['dateFormat' => SORT_DESC],
            'attributes' => [
                'id',
                'dateFormat' => [
                    'asc' => ['pay_history.date' => SORT_ASC],
                    'desc' => ['pay_history.date' => SORT_DESC],
                ],
                'payment',
                'typeFormat' => [
                    'asc' => ['pay_history.type' => SORT_ASC],
                    'desc' => ['pay_history.type' => SORT_DESC],
                ],
                'payStatus' => [
                    'asc' => ['pay_history.status' => SORT_ASC],
                    'desc' => ['pay_history.status' => SORT_DESC],
                ],
            ]
        ]);
        return $this->render('pay-history', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWidgets()
    {
        $result = WidgetSettings::find()->where('user_id='.Yii::$app->user->identity->id)->all();
        return $this->render('widgets',['widgets' => $result]);
    }

    public function actionDeletewidget($id)
    {
        $result = WidgetSettings::findOne(['widget_id' => $id]);
        $result->delete();
        return $this->redirect('/profile/widgets');
    }

    public function actionUserTarif()
    {
        $postArray = Yii::$app->request->post();
        $tarifs = $postArray['Tarifs'];
        $t_id = $tarifs['id'];
        $u_id = $tarifs['user_id'];
        $connection = Yii::$app->db;
        $connection->createCommand()->update('user_tarif',['tarif_id'=>$t_id], "user_id = $u_id")->execute();
        return $this->redirect('index');

    }

    public function actionHistory()
    {
        $messageProvider = new ActiveDataProvider([
            'query' => WidgetSendedEmail::find()->join('INNER JOIN','widget_settings','widget_settings.widget_id=widget_sended_email_messeg.widget_id')->where('widget_settings.user_id='.Yii::$app->user->identity->id),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $callProvider = new ActiveDataProvider([
            'query' => WidgetPendingCalls::find()->join('INNER JOIN','widget_settings','widget_settings.widget_id=widget_pending_calls.widget_id')->where('widget_settings.user_id='.Yii::$app->user->identity->id),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $callProvider->setSort([
            'defaultOrder' => ['call_time' => SORT_DESC],
            'attributes' => [
                'widget_id',
                'call_time',
                'phone',
                'EndSide' => [
                    'asc' => ['widget_pending_calls.end_side' => SORT_ASC],
                    'desc' => ['widget_pending_calls.end_side' => SORT_DESC],
                    'default' => SORT_DESC
                ],
                'waiting_period_A',
                'waiting_period_B',
                'call_back_record_URL_A',
                'call_back_record_URL_B',
                'call_back_cost',
            ]
        ]);

        return $this->render('history', [
            'callProvider' => $callProvider,
            'messageProvider' => $messageProvider
        ]);
    }

    public function actionAddWidget()
    {
        $model = new WidgetSettings();
        $marks = new WidgetActionMarks();
        $widgetTemplate = WidgetTemplateNotification::find()->all();
        $postArray = Yii::$app->request->post();
        if(!empty($postArray))
        {
//            print_r($postArray);
//            die();
            $address = ['http://', 'https://'];
            $url = str_replace($address, '', Yii::$app->request->post('widget_site_url'));
            $code = "user-".Yii::$app->user->identity->id."-url-".$url."-date-".time();
            $model->widget_key = md5($code);
            $model->widget_status = 1;
            $model->widget_site_url = $url;
            $mail = '';
            for($i=1; $i<=$postArray['count_emails']; $i++)
            {
                $index = 'widget_user_email_'.$i;
                $mail.=$postArray[$index].';';
            }
            $model->widget_user_email = $mail;
            $black_list = '';
            for($i=1; $i<=$postArray['count_black_list']; $i++)
            {
                $index = 'black_list_number_'.$i;
                $black_list.=$postArray[$index].';';
            }
            $model->black_list = $black_list;
            $top = empty($postArray['witget-button-top']) ? 'top:0%;' : $postArray['witget-button-top'];
            $left = empty($postArray['witget-button-left']) ? 'left:0%;' : $postArray['witget-button-left'];
            $topMob = empty($postArray['witget-button-top-mob']) ? 'top:0%;' : $postArray['witget-button-top-mob'];
            $leftMob = empty($postArray['witget-button-left-mob']) ? 'left:0%;' : $postArray['witget-button-left-mob'];
            $model->widget_position = $top.$left;
            $model->widget_position_mobile = $topMob.$leftMob;
            $model->widget_name = Yii::$app->request->post('widget_name');
            $model->widget_button_color = Yii::$app->request->post('widget_button_color');
            //$model->widget_work_time = '{"work-start-time":"'.Yii::$app->request->post('work-start-time').'","work-end-time":"'.Yii::$app->request->post('work-end-time').'"}';
            $model->widget_theme_color = Yii::$app->request->post('widget_theme_color');
            $model->widget_yandex_metrika = Yii::$app->request->post('widget_yandex_metrika');
            ($_POST['WidgetSettings']['widget_google_metrika']) ? $model->widget_google_metrika = 1 : $model->widget_google_metrika = 0;
            $phones = '';
            for($i=1; $i<=$postArray['count_phones']; $i++)
            {
                $index = 'widget_phone_number_'.$i;
                $phones.=$postArray[$index].';';
            }
            $model->widget_phone_numbers=$phones;
            $model->user_id = Yii::$app->user->id;
            $model->widget_GMT = Yii::$app->request->post('widget_GMT');

            $work_time['monday']['start'] = $postArray['work-start-time-monday'];
            $work_time['monday']['end'] = $postArray['work-end-time-monday'];
            $work_time['monday']['lunch'] = $postArray['work-lunch-time-monday'];
            $work_time['tuesday']['start'] = $postArray['work-start-time-tuesday'];
            $work_time['tuesday']['end'] = $postArray['work-end-time-tuesday'];
            $work_time['tuesday']['lunch'] = $postArray['work-lunch-time-tuesday'];
            $work_time['wednesday']['start'] = $postArray['work-start-time-wednesday'];
            $work_time['wednesday']['end'] = $postArray['work-end-time-wednesday'];
            $work_time['wednesday']['lunch'] = $postArray['work-lunch-time-wednesday'];
            $work_time['thursday']['start'] = $postArray['work-start-time-thursday'];
            $work_time['thursday']['end'] = $postArray['work-end-time-thursday'];
            $work_time['thursday']['lunch'] = $postArray['work-lunch-time-thursday'];
            $work_time['friday']['start'] = $postArray['work-start-time-friday'];
            $work_time['friday']['end'] = $postArray['work-end-time-friday'];
            $work_time['friday']['lunch'] = $postArray['work-lunch-time-friday'];
            $work_time['saturday']['start'] = $postArray['work-start-time-saturday'];
            $work_time['saturday']['end'] = $postArray['work-end-time-saturday'];
            $work_time['saturday']['lunch'] = $postArray['work-lunch-time-saturday'];
            $work_time['sunday']['start'] = $postArray['work-start-time-sunday'];
            $work_time['sunday']['end'] = $postArray['work-end-time-sunday'];
            $work_time['sunday']['lunch'] = $postArray['work-lunch-time-sunday'];

            $model->widget_work_time = json_encode($work_time);
            $model->widget_sound = Yii::$app->request->post('widget_sound');
            ($_POST['WidgetSettings']['hand_turn_on']) ? $model->hand_turn_on = 1 : $model->hand_turn_on = 0;
            ($_POST['WidgetSettings']['utp_turn_on']) ? $model->utp_turn_on = 1 : $model->utp_turn_on = 0;
            $model->widget_utp_form_position = $_POST['widget-utp-form-top'].$_POST['widget-utp-form-left'];
            $model->utm_button_color = Yii::$app->request->post('utm-button-color');
            $model->utp_img_url = Yii::$app->request->post('utp-img-url');
            if($model->save()) {
                $this->renameFileScreen($model->widget_id, $url, 1);
                $marks->widget_id = $model->widget_id;
                $marks->other_page = $postArray['other_page'];
                $marks->scroll_down = $postArray['scroll_down'];
                $marks->active_more40 = $postArray['active_more40'];
                $marks->mouse_intencivity = $postArray['mouse_intencivity'];
                $marks->sitepage3_activity = $postArray['sitepage3_activity'];
                $marks->more_avgtime = $postArray['more_avgtime'];
                $marks->moretime_after1min = $postArray['moretime_after1min'];
                $marks->form_activity = $postArray['form_activity'];
                $marks->client_activity = $postArray['client_activity'];
                $sites = '';
                for($i=1; $i<=$postArray['count_pages']; $i++)
                {
                    $sites .= $postArray['site_page_'.$i].'*'.$postArray['select_site_page_'.$i].';';
                }
                $marks->site_pages_list = $sites;
                if($marks->save()) {
                    for ($i = 0;$i < count($_POST['template']['id']);$i++) {
                        $widgetTemplateUsers = new WidgetTemplateNotificationUsers();
                        $widgetTemplateUsers->id_widget = $model->widget_id;
                        $widgetTemplateUsers->id_template = $_POST['template']['id'][$i];
                        $widgetTemplateUsers->description = $_POST['template']['description'][$i];
                        $widgetTemplateUsers->param = $_POST['template']['param'][$i];
                        $widgetTemplateUsers->status =  $_POST['template']['change'][$_POST['template']['id'][$i]];
                        $widgetTemplateUsers->save();
                    }
                    return $this->redirect(['profile/widgets']);
                } else {
                    print_r($marks->errors);
                    die();
                }
            } else {
                print_r($model->errors);
                die();
            }
        } else {
            return $this->render('add-widget', [
                'model' => $model,
                'marks' => $marks,
                'widgetTemplate' => $widgetTemplate,
            ]);
        }
    }

    public function actionUpdateWidget($id)
    {
        $model = $this->findModel($id);
        $marks = $this->findMarks($id);
        $widgetTemplate = WidgetTemplateNotification::find()->all();
        $widgetTemplateUsers = WidgetTemplateNotificationUsers::findAll(['id_widget' => $id]);

        $postArray = Yii::$app->request->post();
        if(!empty($postArray))
        {
            $address = ['http://', 'https://'];
            $url = str_replace($address, '', Yii::$app->request->post('widget_site_url'));
            $model->widget_status = 1;
            $model->widget_site_url = $url;
            $email = '';
            for($i=1; $i<=$postArray['count_emails']; $i++)
            {
                $index = 'widget_user_email_'.$i;
                $email.=$postArray[$index].';';
            }
            $model->widget_user_email = $email;
            $black_list = '';
            for($i=1; $i<=$postArray['count_black_list']; $i++)
            {
                $index = 'black_list_number_'.$i;
                $black_list.=$postArray[$index].';';
            }
            $model->black_list = $black_list;
            $model->widget_position = $postArray['witget-button-top'].Yii::$app->request->post('witget-button-left');
            $model->widget_position_mobile = $postArray['witget-button-top-mob'].Yii::$app->request->post('witget-button-left-mob');
            $model->widget_name = Yii::$app->request->post('widget_name');
            $model->widget_button_color = Yii::$app->request->post('widget_button_color');
            //$model->widget_work_time = '{"work-start-time":"'.Yii::$app->request->post('work-start-time').'","work-end-time":"'.Yii::$app->request->post('work-end-time').'"}';
            $model->widget_theme_color = Yii::$app->request->post('widget_theme_color');
            $model->widget_yandex_metrika = Yii::$app->request->post('widget_yandex_metrika');
            ($_POST['WidgetSettings']['widget_google_metrika']) ? $model->widget_google_metrika = 1 : $model->widget_google_metrika = 0;
            $phone = '';
            for($i=1; $i<=$postArray['count_phones']; $i++)
            {
                $index = 'widget_phone_number_'.$i;
                $phone.=$postArray[$index].';';
            }
            $model->widget_phone_numbers = $phone;
            $model->user_id = Yii::$app->user->id;
            $model->widget_GMT = Yii::$app->request->post('widget_GMT');

            $work_time['monday']['start'] = $postArray['work-start-time-monday'];
            $work_time['monday']['end'] = $postArray['work-end-time-monday'];
            $work_time['monday']['lunch'] = $postArray['work-lunch-time-monday'];
            $work_time['tuesday']['start'] = $postArray['work-start-time-tuesday'];
            $work_time['tuesday']['end'] = $postArray['work-end-time-tuesday'];
            $work_time['tuesday']['lunch'] = $postArray['work-lunch-time-tuesday'];
            $work_time['wednesday']['start'] = $postArray['work-start-time-wednesday'];
            $work_time['wednesday']['end'] = $postArray['work-end-time-wednesday'];
            $work_time['wednesday']['lunch'] = $postArray['work-lunch-time-wednesday'];
            $work_time['thursday']['start'] = $postArray['work-start-time-thursday'];
            $work_time['thursday']['end'] = $postArray['work-end-time-thursday'];
            $work_time['thursday']['lunch'] = $postArray['work-lunch-time-thursday'];
            $work_time['friday']['start'] = $postArray['work-start-time-friday'];
            $work_time['friday']['end'] = $postArray['work-end-time-friday'];
            $work_time['friday']['lunch'] = $postArray['work-lunch-time-friday'];
            $work_time['saturday']['start'] = $postArray['work-start-time-saturday'];
            $work_time['saturday']['end'] = $postArray['work-end-time-saturday'];
            $work_time['saturday']['lunch'] = $postArray['work-lunch-time-saturday'];
            $work_time['sunday']['start'] = $postArray['work-start-time-sunday'];
            $work_time['sunday']['end'] = $postArray['work-end-time-sunday'];
            $work_time['sunday']['lunch'] = $postArray['work-lunch-time-sunday'];

            $model->widget_work_time = json_encode($work_time);
            $model->widget_sound = Yii::$app->request->post('widget_sound');
            ($_POST['WidgetSettings']['hand_turn_on']) ? $model->hand_turn_on = 1 : $model->hand_turn_on = 0;
            ($_POST['WidgetSettings']['utp_turn_on']) ? $model->utp_turn_on = 1 : $model->utp_turn_on = 0;
            $model->widget_utp_form_position = $_POST['widget-utp-form-top'].$_POST['widget-utp-form-left'];
            $model->utm_button_color = Yii::$app->request->post('utm-button-color');
            $model->utp_img_url = Yii::$app->request->post('utp-img-url');
            if($model->save()) {
                $this->renameFileScreen($model->widget_id, $url, 2);
                $marks->widget_id = $model->widget_id;
                $marks->other_page = $postArray['other_page'];
                $marks->scroll_down = $postArray['scroll_down'];
                $marks->active_more40 = $postArray['active_more40'];
                $marks->mouse_intencivity = $postArray['mouse_intencivity'];
                $marks->sitepage3_activity = $postArray['sitepage3_activity'];
                $marks->more_avgtime = $postArray['more_avgtime'];
                $marks->moretime_after1min = $postArray['moretime_after1min'];
                $marks->form_activity = $postArray['form_activity'];
                $marks->client_activity = $postArray['client_activity'];
                $sites = '';
                for($i=1; $i<=$postArray['count_pages']; $i++)
                {
                    $sites .= $postArray['site_page_'.$i].'*'.$postArray['select_site_page_'.$i].';';
                }
                $marks->site_pages_list = $sites;
                if($marks->save()) {
                    if ($widgetTemplateUsers) {
                        foreach ($widgetTemplateUsers as $key => $value) {
                            $value->id_widget = $model->widget_id;
                            $value->id_template = $_POST['template']['id'][$key];
                            $value->description = $_POST['template']['description'][$key];
                            $value->param = $_POST['template']['param'][$key];
                            $value->status = $_POST['template']['change'][$_POST['template']['id'][$key]];
                            $value->save();
                        }
                    } else {
                        for ($i = 0;$i < count($_POST['template']['id']);$i++) {
                            $widgetTemplateUsers = new WidgetTemplateNotificationUsers();
                            $widgetTemplateUsers->id_widget = $model->widget_id;
                            $widgetTemplateUsers->id_template = $_POST['template']['id'][$i];
                            $widgetTemplateUsers->description = $_POST['template']['description'][$i];
                            $widgetTemplateUsers->param = $_POST['template']['param'][$i];
                            $widgetTemplateUsers->status = $_POST['template']['change'][$_POST['template']['id'][$i]];
                            $widgetTemplateUsers->save();
                        }
                    }
                    return $this->redirect(['profile/widgets']);
                } else {
                    print_r($marks->errors);
                    die();
                }
            } else {
                print_r($model->errors);
                die();
            }
        } else {
            return $this->render('update-widget', [
                'model' => $model,
                'marks' => $marks,
                'widgetTemplate' => $widgetTemplate,
                'widgetTemplateUsers' => $widgetTemplateUsers
            ]);
        }
    }

    public function actionSound()
    {
        return $this->render('sound');
    }

    public function actionPayWith()
    {
        $model = new Paymant();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('pay-with');
        }
        else
        {
            return $this->render('pay-with');
        }
    }

    public function actionSavesiteimage()
    {
        if ($_POST) {
            $path = '/files/images/desktop/';
            $path2 = '/files/images/mobile/';
            if (!file_exists(Yii::getAlias('@webroot').$path)){
                mkdir(Yii::getAlias('@webroot').$path, 0777, true);
                file_put_contents(Yii::getAlias('@webroot').$path.$_POST['site'].'.jpg', file_get_contents($_POST['url_desktop']));
            } else {
                file_put_contents(Yii::getAlias('@webroot').$path.$_POST['site'].'.jpg', file_get_contents($_POST['url_desktop']));
            }
            if (!file_exists(Yii::getAlias('@webroot').$path2)){
                mkdir(Yii::getAlias('@webroot').$path2, 0777, true);
                file_put_contents(Yii::getAlias('@webroot').$path2.$_POST['site'].'.jpg', file_get_contents($_POST['url_mobile']));
            } else {
                file_put_contents(Yii::getAlias('@webroot').$path2.$_POST['site'].'.jpg', file_get_contents($_POST['url_mobile']));
            }
        }
    }

    protected function renameFileScreen($widgetId, $url, $action)
    {
        $path = '/files/images/desktop/';
        $path2 = '/files/images/mobile/';
        if (file_exists(Yii::getAlias('@webroot').$path.$url.'.jpg')){
            $new_path = $action == 1 ? Yii::getAlias('@webroot').$path.$url.'.jpg' : Yii::getAlias('@webroot').$path.$widgetId.'-'.$url.'.jpg';
            if (file_exists(Yii::getAlias('@webroot').$path.$widgetId.'-'.$url.'.jpg')) {
                rename($new_path, Yii::getAlias('@webroot') . $path . $widgetId . '-' . $url . '.jpg');
            } else {
                rename(Yii::getAlias('@webroot').$path.$url.'.jpg', Yii::getAlias('@webroot') . $path . $widgetId . '-' . $url . '.jpg');
            }
        }
        if (file_exists(Yii::getAlias('@webroot').$path2.$url.'.jpg')){
            $new_path2 = $action == 1 ? Yii::getAlias('@webroot').$path2.$url.'.jpg' : Yii::getAlias('@webroot').$path2.$widgetId.'-'.$url.'.jpg';
            if (file_exists(Yii::getAlias('@webroot').$path2.$widgetId.'-'.$url.'.jpg')) {
                rename($new_path2, Yii::getAlias('@webroot') . $path2 . $widgetId . '-' . $url . '.jpg');
            } else {
                rename(Yii::getAlias('@webroot').$path2.$url.'.jpg', Yii::getAlias('@webroot') . $path2 . $widgetId . '-' . $url . '.jpg');
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = WidgetSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findMarks($id)
    {
        if (($model = WidgetActionMarks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdatePaidIk()
    {
        return $this->render('paid-ik');
    }

    public function actionUpdateUser()
    {
        $user = $_POST['User'];
        $to_save = User::findOne(Yii::$app->user->id);
        $to_save->name = $user['name'];
        $to_save->email = $user['email'];
        $to_save->phone = $user['phone'];
        $to_save->cache_notification = $user['cache_notification'];
        $to_save->save();

        return $this->redirect('/profile');
    }

}
