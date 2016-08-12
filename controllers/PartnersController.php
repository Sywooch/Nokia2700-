<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;

class PartnersController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'sendmail', 'promo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        $this->layout = "@app/views/layouts/profile";
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $dataProviderLeft = new ActiveDataProvider([
            'query' => User::findBySql("
                SELECT user_id, name, create_at,
                (SELECT COUNT(*) FROM users as u2 WHERE u2.partner = u1.user_id AND u2.status = 1) as partners_count
                FROM users as u1
                WHERE partner = ".Yii::$app->user->id." AND status = 1
            "),
            'sort' => [
                'defaultOrder' => ['create_at' => SORT_DESC],
            ],
        ]);
        $dataProviderRight = new ActiveDataProvider([
            'query' => User::findBySql("
                SELECT user_id, name, create_at
                FROM users as u1
                WHERE partner IN (
                  SELECT user_id
                  FROM users as u1
                  WHERE partner = ".Yii::$app->user->id." AND status = 1
                ) AND status = 1
            "),
            'sort' => [
                'defaultOrder' => ['create_at' => SORT_DESC],
            ],
        ]);

        return $this->render('index', [
            'dataProviderLeft' => $dataProviderLeft,
            'dataProviderRight' => $dataProviderRight,
        ]);
    }

    public function actionPromo()
    {
        return $this->render('promo');
    }

    public function actionSendmail()
    {
        if ($_POST) {
            $mails_explode = explode(' ', $_POST['mails']);
            $mails_explode = explode(',', implode('', $mails_explode));
            $mails = array();
            for($i = 0;$i < count($mails_explode);$i++){
                if ($this->validateEmail($mails_explode[$i])) {
                    $mails[] = trim($mails_explode[$i]);
                }
            }

            $subject = "Приглашаем вас в robax!";
            $link = 'http://'.$_SERVER['HTTP_HOST'].'/register?ref='.Yii::$app->user->id;
            $message =
                '<html>
                    <head>
                        <title>Приглашаем вас в robax!</title>
                    </head>
                    <body>
                        <p>Установите себе на сайт замечательный виджет обратного звонка Robax!</p>
                        <p>'.$link.'</p>
                        <p>Спасибо за внимание!</p>
                    </body>
                </html>';
            Yii::$app->mailer->compose()
                ->setTo($mails)
                ->setFrom('robax@oblax.ru')
                ->setSubject($subject)
                ->setHtmlBody($message)
                ->send();

        }
        return $this->redirect('/partners');
    }

    function validateEmail($email) {
        $pattern = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
        if(!preg_match($pattern, $email)) {
            return false;
        } else {
            return true;
        }
    }

}
