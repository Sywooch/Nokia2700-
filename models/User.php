<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\web\IdentityInterface;
use yii\helpers\Url;

/**
 * This is the model class for table "users".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $pass
 * @property string $password_hash
 * @property string $password_token
 * @property string $create_at
 * @property integer $cache
 * @property string $phone
 * @property string $activation
 * @property string $status
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $auth_key;
    const DEACTIVATED = '0';
    const ACTIVATED = '1';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'pass', 'phone'], 'required'],
            [['create_at'], 'safe'],
            [['cache'], 'integer'],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['email', 'pass', 'password_hash', 'password_token'], 'string', 'max' => 120],
            [['phone'], 'string', 'max' => 15],
            [['activation'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'email' => 'Email',
            'pass' => 'Pass',
            'password_hash' => 'Password Hash',
            'password_token' => 'Password Token',
            'create_at' => 'Create At',
            'cache' => 'Cache',
            'phone' => 'Phone',
            'activation' => 'Activation',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {
            $this->activation = $this->generateActivationCode();
            $this->sendCode($this->email, $this->activation);
            $this->pass = Yii::$app->getSecurity()->generatePasswordHash($this->pass);
            $this->status = self::DEACTIVATED;
        }
        return parent::beforeSave($insert);
    }

    public function generateActivationCode()
    {
        $rest = md5(uniqid(rand(),true));
        $activation = substr($rest,0,8);
        return $activation;
    }

    public function activateUser($code)
    {
        $user = User::find()->where("activation ='".$code."'")->one();
        $user->status = self::ACTIVATED;
        if($user->save()) {
            return true;
        } else {
            print_r($user->errors);
            die();
        }
    }

    public function sendCode($email,$code)
    {
        $subject = "Благодарим вас за регистрацию на портале robax!";
        $link = Url::to('/site/activate/',true).$code;
        $message =
        '<html>
            <head>
                <title>Благодарим вас за регистрацию на портале robax!</title>
            </head>
            <body>
                <p>Регистрация прошла успешно!</p>
                <p>Чтобы подтвердить вашу учётную запись, пройдите по ссылке</p>
                <p>'.$link.'</p>
                <p>Спасибо за регистрацию!</p>
            </body>
        </html>';
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom('raposya@yandex.ru')
            ->setSubject($subject)
            ->setTextBody($message)
            ->send();
        return true;
    }

    public function getWidgets()
    {
        return $this
            ->hasMany(WidgetSettings::className(), ['user_id' => 'user_id'])       
            ->viaTable(WidgetSettings::tableName(), ['user_id' => 'user_id']);     
    }

    public static function findByEmail($email)
    {
        $user = User::find()->where("email ='".$email."'")->one();
        return $user;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->pass);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->user_id;
    }

    public static function getOrderNum($user_id)
    {
        $userid = $user_id;
        $query = new Query;
        $query->select('id')->from('pay_history')
        ->where("user_id='".$userid."'")
        ->orderBy('id DESC');
        $orderid = $query->one();
        $ordernum = "uid".$userid."_000".($orderid["id"]+1);
        return $ordernum;
    }

    public static function Pay($total, $order, $name, $email, $phone)
    {
        $mrh_login = "oblax";
        $mrh_pass1 = "jo03SwqUJEtEGrVq946n";
        $inv_id = Yii::$app->user->identity->id;
        $inv_desc = "Оплата робакса";
        $out_summ = $total;
        $shp_item = 1;
        $in_curr = "";
        $culture = "ru";
        $encoding = "utf-8";
        $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
        print "<html>".
              "<form action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
              "<input type=hidden name=MrchLogin value=$mrh_login>".
              "<input type=hidden name=OutSum value=$out_summ><br>".
              "<input type=hidden name=InvId value=$inv_id>".
              "<input type=hidden name=Desc value='$inv_desc'>".
              "<input type=hidden name=SignatureValue value=$crc>".
              "<input type=hidden name=Shp_item value='$shp_item'>".
              "<input type=hidden name=IncCurrLabel value=$in_curr>".
              "<input type=hidden name=Culture value=$culture>".
              "<input type=submit class='btn btn-success btn-block' value='Подтвердить'>".
              "</form></html>";
    }

    public static function PayInterKassa($total, $order, $name, $email, $phone)
    {
        $key ='ENS7Q8C4qS2hYcb9';

        $dataSet=array();
        $dataSet["ik_co_id"]    = "5797453a3c1eaf0f778b456b";
        $dataSet["ik_pm_no"] = "$order";
        $dataSet["ik_am"]    = "$total";
        $dataSet["ik_sign"]    = "";
        $dataSet["ik_cur"]     = "RUB";
        $dataSet["ik_desc"]    = "Оплата робакса";
        $dataSet["ik_suc_u"]    = "http://r.oblax.ru/profile/paid-ik";
        $dataSet["ik_suc_m"] = "POST";
        $dataSet["ik_fal_u"]       = "http://r.oblax.ru/profile/fail";
        $dataSet["ik_fal_m"] = "POST";
        $dataSet["ik_x_name"] = $name;
        $dataSet["ik_x_phone"] = $phone;
        $dataSet["ik_cli"] = $email;



        unset($dataSet['ik_sign']); //удаляем из данных строку подписи
        ksort($dataSet, SORT_STRING); // сортируем по ключам в алфавитном порядке элементы массива
        array_push($dataSet, $key); // добавляем в конец массива "секретный ключ"
        $signString = implode(':', $dataSet); // конкатенируем значения через символ ":"
        $sign = base64_encode(md5($signString, true)); // берем MD5 хэш в бинарном виде по сформированной строке и кодируем в BASE64

//        echo ($signString);
//        print_r($sign);
        $dataSet["ik_sign"] = $sign;
//        unset($dataSet['0']);
        print "<html><form id='payment' name='payment' method=POST action='https://sci.interkassa.com/' enctype='utf-8'>";
        foreach($dataSet as $key => $val)
        {
            if(is_array($val))
                foreach($val as $value)
                {
                    print "<input hidden type='hidden' name='$key' value='$value'/>";
                }
            else
                print "<input hidden type='hidden' name='$key' value='$val'/>";
        }
        print "<input type=submit class='btn btn-success btn-block' value='Подтвердить'></form></html>";

        PayHistory::addHistoryPayment($total, $email, $order);

    }

    public static function PayWalletOne($total, $order, $name, $email, $phone)
    {
        $key = '624a636670417a72596a6a364b6b4c5b425659476b6e4b776d546f';

        $fields = array();
        $fields["WMI_MERCHANT_ID"]    = "133174540555";
        $fields["WMI_PAYMENT_AMOUNT"] = "$total";
        $fields["WMI_CURRENCY_ID"]    = "643";
        $fields["WMI_PAYMENT_NO"]     = "$order";
        $fields["WMI_DESCRIPTION"]    = "BASE64:".base64_encode("Счет № ".$order." Оплата робакса");
        $fields["WMI_SUCCESS_URL"]    = "http://r.oblax.ru/profile/paid";
        $fields["WMI_FAIL_URL"]       = "http://r.oblax.ru/profile/fail";
        $fields["MyShopParam1"]       = "$name"; // Дополнительные параметры
        $fields["MyShopParam2"]       = "$email"; // интернет-магазина тоже участвуют
        $fields["MyShopParam3"]       = "$phone"; // при формировании подписи!


        foreach($fields as $name => $val)
        {
            if(is_array($val))
            {
                usort($val, "strcasecmp");
                $fields[$name] = $val;
            }
        }

        // Формирование сообщения, путем объединения значений формы,
        // отсортированных по именам ключей в порядке возрастания.
        uksort($fields, "strcasecmp");
        $fieldValues = "";

        foreach($fields as $value)
        {
            if(is_array($value))
                foreach($value as $v)
                {
                    //Конвертация из текущей кодировки (UTF-8)
                    //необходима только если кодировка магазина отлична от Windows-1251
                    $v = iconv("utf-8", "windows-1251", $v);
                    $fieldValues .= $v;
                }
            else
            {
                //Конвертация из текущей кодировки (UTF-8)
                //необходима только если кодировка магазина отлична от Windows-1251
                $value = iconv("utf-8", "windows-1251", $value);
                $fieldValues .= $value;
            }
        }

        // Формирование значения параметра WMI_SIGNATURE, путем
        // вычисления отпечатка, сформированного выше сообщения,
        // по алгоритму MD5 и представление его в Base64

        $signature = base64_encode(pack("H*", md5($fieldValues . $key)));

        //Добавление параметра WMI_SIGNATURE в словарь параметров формы

        $fields["WMI_SIGNATURE"] = $signature;

//        print $signature;
        // Формирование HTML-кода платежной формы

        print "<form action='https://wl.walletone.com/checkout/checkout/Index' method='POST' accept-charset='UTF-8'>";

        foreach($fields as $key => $val)
        {
            if(is_array($val))
                foreach($val as $value)
                {
                    print "<input hidden type='text' name='$key' value='$value'/>";
                }
            else
                print "<input hidden type='text' name='$key' value='$val'/>";
        }

        print "<input type='submit' class='btn btn-success btn-block' value='Подтвердить'/></form>";

        PayHistory::addHistoryPayment($total, $email, $order);

    }

}
