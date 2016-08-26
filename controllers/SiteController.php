<?php

namespace app\controllers;

use app\models\Cron;
use app\models\PartnerLink;
use app\models\WidgetOrderCall;
use app\models\WidgetSettings;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = 'auth';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        $model->rememberMe = ($model->rememberMe=='on') ? 1 : 0;
        if ($model->login()) {
            return $this->redirect(['/profile']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $this->layout = 'auth';
        if (Yii::$app->user->isGuest) {
            if (isset($_GET['ref'])) {
                setcookie('ref', $_GET['ref']);
                return $this->redirect(['/register']);
            }
        }
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        if (isset($_COOKIE['ref'])) {
            $model->setAttribute('partner', $_COOKIE['ref']);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('userRegistered');
            if (isset($_COOKIE['ref'])) {
                setcookie('ref', '');
            }
            return $this->redirect(['site/login']);
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLink($link)
    {
        if (Yii::$app->user->isGuest) {
            if (isset($link)) {
                $partnerLin = PartnerLink::findOne(['link' => $link]);
                setcookie('ref', $partnerLin->id_user);
                return $this->redirect(['/register?ref='.$partnerLin->id_user]);
            }
        }

        return $this->redirect('/register');
    }

    public function actionActivate($code)
    {
        if(User::activateUser($code)) {
           Yii::$app->session->setFlash('userActivated'); 
           return $this->redirect(['site/login']);
        }
        return false;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCron()
    {
        $WidgetOrderCall = WidgetOrderCall::findAll(["date" => date("Y-m-d"), "status" => 0]);
        foreach ($WidgetOrderCall as $key => $value) {
            if ($value["time"] == date("H:i:s")) {
                $widget = WidgetSettings::getJSONWidget($value["key"], $value["url"]);
                $WidgetSettings = new WidgetSettings();
                $WidgetSettings->widgetCall($value["phone"], "cron", $widget);

                $WidgetOrderCall = WidgetOrderCall::findOne(["id" => $value["id"]]);
                $WidgetOrderCall->status = 1;
                if (!$WidgetOrderCall->save()) print_r($WidgetOrderCall->getErrors());
            }
        }
        return true;
    }
}
