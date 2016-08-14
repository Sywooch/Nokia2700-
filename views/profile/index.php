<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Paymant;
use app\models\Tarifs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\WidgetCatching;

$this->title = 'Профиль пользователя';

$cur_tarif = Tarifs::getUserTarif(Yii::$app->user->identity->id)['0'];
$name = isset(Yii::$app->user->identity->name) ? Yii::$app->user->identity->name : '' ;
$cache = isset(Yii::$app->user->identity->cache) ? Yii::$app->user->identity->cache : '' ;
$email = isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : '' ;
$id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : '' ;
$phone = isset(Yii::$app->user->identity->phone) ? Yii::$app->user->identity->phone : '' ;
$date = isset(Yii::$app->user->identity->create_at) ? new DateTime(Yii::$app->user->identity->create_at) : new DateTime();
?>
<section class="content-header">
    <h1><?=$this->title?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="/images/user2-160x160.jpg" alt="User profile picture">
                    <h3 class="profile-username text-center"><?=$name?></h3>
                    <!--<p class="text-muted text-center">Software Engineer</p>-->
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Баланс</b> <a class="pull-right"><?=$cache?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Виджеты</b> <a class="pull-right"><?=$widgetSettings?></a>
                        </li>
                    </ul>
                    <a href="<?=Url::to('/profile/pay');?>" class="btn btn-primary btn-block"><b>Пополнить счёт</b></a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Общая информация</a></li>
                    <li class=""><a href="#tarif" data-toggle="tab">Текущий тарифный план</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>ID пользователя</td>
                                    <td><?=$id?></td>
                                </tr>
                                <tr>
                                    <td>Имя пользователя</td>
                                    <td id="changeName"><?=$name?></td>
                                </tr>
                                <tr>
                                    <td>Почта пользователя</td>
                                    <td id="changeEmail"><?=$email?></td>
                                </tr>
                                <tr>
                                    <td>Телефон пользователя</td>
                                    <td id="changePhone"><?=$phone?></td>
                                </tr>
                                <tr>
                                    <td>Дата создания</td>
                                    <td><?=$date->format('d.m.Y H:i:s');?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tarif">
                        <div class="row">
                            <div class="clearfix visible-sm-block"></div>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="box box-widget widget-user-2">
                                    <!-- Add the bg color to the header using any of the bg-* classes -->
                                    <div class="widget-user-header bg-light-blue">
                                        <div class="widget-user-image">
                                            <i class="icon ion-ios-telephone-outline"></i>
                                        </div>
                                        <!-- /.widget-user-image -->
                                        <h3 class="widget-user-username"><? echo $cur_tarif['tarif_name']?></h3>
                                    </div>
                                    <div class="box-footer no-padding">
                                        <ul class="nav nav-stacked">
                                            <li><a href="#">Абонентская плата <span class="pull-right badge bg-light-blue"><?=$cur_tarif['price']." "?> руб.</span></a></li>
                                            <li><a href="#">Стоимость минуты звонка <span class="pull-right badge bg-light-blue"><?=$cur_tarif['minute_price']." "?> руб.</span></a></li>
                                            <li><a href="#">Стоимость одного смс <span class="pull-right badge bg-light-blue"><?=$cur_tarif['sms_price']." "?> руб.</span></a></li>
                                        </ul>
                                        <a href="<?=Url::to('/profile/tarifs');?>" class="btn btn-primary btn-block"><b>Изменить тарифный план</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>