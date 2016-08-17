<?php

namespace app\controllers;

use app\models\Bonus;
use app\models\BonusHistory;
use app\models\Paymant;
use app\models\PartnerLink;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
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
                        'actions' => [
                            'index', 'sendmail', 'promo',
                            'changelink', 'bonus-history',
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

            $partnerLink = PartnerLink::findOne(['id_user' => Yii::$app->user->id]);
            $subject = "Приглашаем вас в robax!";
            $link = 'http://'.$_SERVER['HTTP_HOST'].'/'.($partnerLink->link) ? $partnerLink->link : 'register?ref='.Yii::$app->user->id;
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

    public function actionChangelink()
    {
        if ($_POST) {
            $partnerLink = PartnerLink::findOne(['id_user' => Yii::$app->user->id]);
            if ($partnerLink) {
                $partnerLink->link = $_POST['link'];
                $partnerLink->save();
            } else {
                $partnerLink = new PartnerLink();
                $partnerLink->id_user = Yii::$app->user->id;
                $partnerLink->link = $_POST['link'];
                $partnerLink->save();
            }
        }

        return $this->redirect('/partners');
    }

    public function actionBonusHistory()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BonusHistory::find()->where('user_id='.Yii::$app->user->identity->id),
        ]);
        $dataProviderDesc = new ActiveDataProvider([
            'query' => Bonus::find()->where('partner_id ="'.Yii::$app->user->identity->id.'"')
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['dateFormat' => SORT_DESC],
            'attributes' => [
                'order_num',
                'dateFormat' => [
                    'asc' => ['bonus_history.date' => SORT_ASC],
                    'desc' => ['bonus_history.date' => SORT_DESC],
                ],
                'payment',
                'typeFormat' => [
                    'asc' => ['bonus_history.type' => SORT_ASC],
                    'desc' => ['bonus_history.type' => SORT_DESC],
                ],
                'payStatus' => [
                    'asc' => ['bonus_history.status' => SORT_ASC],
                    'desc' => ['bonus_history.status' => SORT_DESC],
                ],
            ]
        ]);
        $dataProviderDesc->setSort([
            'defaultOrder' => ['dateFormat' => SORT_DESC],
            'attributes' => [
                'client',
                'dateFormat' => [
                    'asc' => ['pay_for_partners.date' => SORT_ASC],
                    'desc' => ['pay_for_partners.date' => SORT_DESC],
                ],
                'client_paid_sum',
                'payment',
                'description' ,
            ]
        ]);
        return $this->render('bonus-history', [
            'dataProvider' => $dataProvider,
            'dataProviderDesc' => $dataProviderDesc,
        ]);
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
