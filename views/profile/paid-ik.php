<?php

$this->registerJsFile('@web/plugins/bootstrap/js/bootstrap.min.js');
use app\models\PayHistory;
use app\models\User;
use yii\bootstrap\Html;
use yii\helpers\Url;

/*$_POST=[
    "MyShopParam1"=>"%de%f0%e8%e9",
    "MyShopParam2"=> "lovehardgame%40yandex.ru",
    "MyShopParam3"=> "12345",
    "WMI_AUTO_ACCEPT"=> "1",
    "WMI_COMMISSION_AMOUNT"=> "0.05",
    "WMI_CREATE_DATE"=> "2016-07-28+11%3a48%3a10",
    "WMI_CURRENCY_ID"=> "643",
    "WMI_DESCRIPTION"=> "Payment+for+order+uid2-0003+in+MYSHOP.com",
    "WMI_EXPIRED_DATE" =>"2016-08-28+11%3a48%3a10",
    "WMI_FAIL_URL"=> "http%3a%2f%2fr.oblax.ru%2fprofile%2ffail",
    "WMI_LAST_NOTIFY_DATE"=> "2016-07-28+13%3a20%3a30",
    "WMI_MERCHANT_ID"=> "133174540555",
    "WMI_NOTIFY_COUNT" =>"15",
    "WMI_ORDER_ID"=> "337400235217",
    "WMI_ORDER_STATE"=> "Accepted",
    "WMI_PAYMENT_AMOUNT" =>"1.00",
    "WMI_PAYMENT_NO" =>"uid2-0003",
    "WMI_PAYMENT_TYPE" =>"SberonlineRUB",
    "WMI_SUCCESS_URL"=> "http%3a%2f%2fr.oblax.ru%2fprofile%2fpaid",
    "WMI_UPDATE_DATE"=> "2016-07-28+12%3a06%3a41",
    "WMI_SIGNATURE"=> "ZOU7AzPeOSacqbKCBe23Vw%3d%3d",
];*/
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";*/

if(!empty($_POST)) {
?>

<div class="content">
    <section class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div>
            <div class="line-time">
                <div class="alert alert-success " role="alert">
                    Пополнение прошло удачно!
                </div>
            </div>
            <div>
                <div class="line-time">
                    <?= Html::button('Вернуться в профиль', ['class' => 'btn btn-block btn-info']) ?>
                </div>
            </div>
        </div>
        <?
        if ($_POST['ik_inv_st'] === 'success') {
            $user_id = (integer)substr($_POST["ik_pm_no"], 8);
            $hist = PayHistory::findone($user_id);
            $hist->status = 1;
            $hist->save();
        }
        //            $pArr = $_POST;
        //          /*  echo "<pre>";
        //            print_r($pArr);
        //            echo "</pre>";*/
        //            \app\models\PayHistory::addHistoryPayment($pArr["WMI_PAYMENT_AMOUNT"], $pArr["MyShopParam2"], $pArr["WMI_PAYMENT_NO"]);
        //
        //        // Секретный ключ интернет-магазина (настраивается в кабинете)
        //        $skey = "ENS7Q8C4qS2hYcb9";
        //
        //        // Функция, которая возвращает результат в Единую кассу
        //    echo "<div hidden class='content'>";
        //        function print_answer($result, $description)
        //        {
        //            print "WMI_RESULT=" . strtoupper($result) . "&";
        //            print "WMI_DESCRIPTION=" .urlencode($description);
        // //           exit();
        //        }
        //
        //        // Проверка наличия необходимых параметров в POST-запросе
        //
        //        if (!isset($_POST["WMI_SIGNATURE"]))
        //            print_answer("Retry", "Отсутствует параметр WMI_SIGNATURE");
        //
        //        if (!isset($_POST["WMI_PAYMENT_NO"]))
        //            print_answer("Retry", "Отсутствует параметр WMI_PAYMENT_NO");
        //
        //        if (!isset($_POST["WMI_ORDER_STATE"]))
        //            print_answer("Retry", "Отсутствует параметр WMI_ORDER_STATE");
        //
        //        // Извлечение всех параметров POST-запроса, кроме WMI_SIGNATURE
        //
        //        foreach($_POST as $name => $value)
        //        {
        //            if ($name !== "WMI_SIGNATURE") $params[$name] = urldecode($value);
        //        }
        //
        //        // Сортировка массива по именам ключей в порядке возрастания
        //        // и формирование сообщения, путем объединения значений формы
        //
        //        uksort($params, "strcasecmp"); $values = "";
        //
        //        foreach($params as $name => $value)
        //        {
        //
        //            $values .= $value;
        //        }
        //
        //        // Формирование подписи для сравнения ее с параметром WMI_SIGNATURE
        //
        //        $signature = base64_encode(pack("H*", md5($values . $skey)));
        //
        //        //Сравнение полученной подписи с подписью W1
        //
        //        if ($signature == urldecode($_POST["WMI_SIGNATURE"]))
        //        {
        //            if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED")
        //            {
        //                // TODO: Пометить заказ, как «Оплаченный» в системе учета магазина
        //
        //                print_answer("Ok", "Заказ #" . $_POST["WMI_PAYMENT_NO"] . " оплачен!");
        //            }
        //            else
        //            {
        //                // Случилось что-то странное, пришло неизвестное состояние заказа
        //
        //                print_answer("Retry", "Неверное состояние ". $_POST["WMI_ORDER_STATE"]);
        //            }
        //        }
        //        else
        //        {
        //            // Подпись не совпадает, возможно вы поменяли настройки интернет-магазина
        //
        //            print_answer("Retry", "Неверная подпись " . $_POST["WMI_SIGNATURE"]);
        //        }
        //
        //    echo "<div>";
        //        }
        }
        else
        {
            Yii::$app->getResponse()->redirect('fail');
        }
        ?>
    </section>
    <script>
        $('.btn-info').click(function(){
            window.location.href='/profile/';
        });
    </script>
<?


?>
</div>
