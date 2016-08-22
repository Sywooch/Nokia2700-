<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 27.07.2016
 * Time: 17:37
 */
$this->registerJsFile('@web/plugins/bootstrap/js/bootstrap.min.js');
use \app\models\User;
use yii\bootstrap\Html;

$this->title = 'Подтверждение пополнения';
$postArray = Yii::$app->request->post('Paymant');
$order = User::getOrderNum(Yii::$app->user->identity->id);
$userinfo = Yii::$app->user->identity;


/*echo "<pre>";
print_r(User::getOrderNum(Yii::$app->user->identity->id));
echo "</pre>";*/
?>

<div xmlns="http://www.w3.org/1999/html">
    <section class="col-lg-1 col-sm-1 col-md-1 col-xs-1"></section>
    <section class="content col-xs-8 col-sm-6 col-md-5 col-lg-5">
        <div class="row">
            <section class="content-header col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1><?=$this->title?></h1>
            </section>
        </div>

        <div>
            <div class="row">
                <form class="form-horizontal">
                    <div class="form-group">
                        <div class="row">
                            <label  class="col-xs-8 col-sm-6 col-md-4 col-lg-4 control-label" >Имя: </label>
                            <div>
                                <p class="form-control-static"><?=$userinfo->name?></p>
                            </div>
                        </div>
                        <div class="row">
                            <label  class="col-xs-8 col-sm-6 col-md-4 col-lg-4 control-label">e-mail: </label>
                            <div>
                                <p class="form-control-static"><?=$userinfo->email?></p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="email" class="col-xs-8 col-sm-6 col-md-4 col-lg-4 control-label">Телефон: </label>
                            <div >
                                <p class="form-control-static"><?=$userinfo->phone?></p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="email" class="col-xs-8 col-sm-6 col-md-4 col-lg-4 control-label">Баланс: </label>
                            <div >
                                <p class="form-control-static"><?=$userinfo->cache?></p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="email" class="col-xs-8 col-sm-6 col-md-4 col-lg-4 control-label">№ заказа: </label>
                            <div >
                                <p class="form-control-static"><?=$order?></p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="email" class="col-xs-8 col-sm-6 col-md-4 col-lg-4 control-label">Сервис оплаты: </label>
                            <div >
                                <p class="form-control-static"><?=$postArray['paywith']?></p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="email" class="col-xs-8 col-sm-6 col-md-4 col-lg-4 control-label">Сумма пополнения: </label>
                            <div >
                                <p class="form-control-static"><?=$postArray['summ']?></p>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                if(isset($postArray))
                {
                    /*    echo "<pre>";
                        print_r(Yii::$app->user->identity);
                        echo "</pre>";*/


                    switch ($postArray['paywith']) {
                        case 'Roboxchange':
                            User::Pay($postArray['summ'], $order, $userinfo->name, $userinfo->email, $userinfo->phone);
                            break;
                        case 'WalletOne':
                            User::PayWalletOne($postArray['summ'], $order, $userinfo->name, $userinfo->email, $userinfo->phone);
                            break;
                        case 'InterKassa':
                            User::PayInterKassa($postArray['summ'], $order, $userinfo->name, $userinfo->email, $userinfo->phone);
                            break;
                    }
                }
                ?>
                <br>
                <div class="line-time">
                    <?= Html::button('Отменить', ['class' => 'btn btn-block btn-danger']) ?>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('.btn-danger').click(function(){
            window.location.href='pay';
        });
    </script>
</div>