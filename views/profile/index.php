<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Tarifs;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Профиль пользователя';

$cur_tarif = Tarifs::getUserTarif(Yii::$app->user->id)['0'];
$user = User::findIdentity(Yii::$app->user->id);

$name = isset(Yii::$app->user->identity->name) ? Yii::$app->user->identity->name : '' ;
$cache = isset(Yii::$app->user->identity->cache) ? Yii::$app->user->identity->cache : '' ;
$bonuses = isset(Yii::$app->user->identity->bonus) ? Yii::$app->user->identity->bonus : '' ;
$id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '' ;
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
                <div class="tab-content" style="padding-bottom: 0;">
                    <div class="active tab-pane" id="activity">
                        <? $formUser = ActiveForm::begin(['action'=>'/profile/update-user'])?>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td style="vertical-align: middle;">ID пользователя</td>
                                <td>
                                    <?=$formUser->field($user, 'id')->label(false)->textInput([
                                        'readonly'=>true,
                                        'class'=> 'col-md-12 col-sm-12 col-xs-12',
                                        'style' => 'border: none;padding-left: 0;'
                                    ])?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">Имя пользователя</td>
                                <td>
                                    <?=$formUser->field($user, 'name')->label(false)->textInput([
                                        'readonly'=>true,
                                        'class'=> 'col-md-12 col-sm-12 col-xs-12',
                                        'style' => 'border: none;padding-left: 0;'
                                    ])?>
                                </td>
                                <td>
                                    <a id="name" style="cursor: pointer;" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
                                    <?= Html::a('<span class="col-md-12 col-sm-12 col-xs-12"><i class="fa fa-save"></i></span>','', ['class' => 'sub_link', 'id'=>"save_name", 'hidden'=>true])?>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">Почта пользователя</td>
                                <td>
                                    <?=$formUser->field($user, 'email')->label(false)->textInput([
                                        'readonly'=>true,
                                        'class'=> 'col-md-12 col-sm-12 col-xs-12',
                                        'style' => 'border: none;padding-left: 0;'
                                    ])?>
                                </td>
                                <td>
                                    <a id="email" style="cursor: pointer;" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
                                    <?= Html::a('<span class="col-md-12 col-sm-12 col-xs-12"><i class="fa fa-save"></i></span>','', ['class' => 'sub_link', 'id'=>"save_email", 'hidden'=>true])?>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">Телефон пользователя</td>
                                <td>
                                    <?=$formUser->field($user, 'phone')->label(false)->textInput([
                                        'readonly'=>true,
                                        'class'=> 'col-md-12 col-sm-12 col-xs-12',
                                        'style' => 'border: none;padding-left: 0;'
                                    ])?>
                                </td>
                                <td>
                                    <a id="phone" style="cursor: pointer;" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
                                    <?= Html::a('<span class="col-md-12 col-sm-12 col-xs-12"><i class="fa fa-save"></i></span>','', ['class' => 'sub_link', 'id'=>"save_phone", 'hidden'=>true])?>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">Дата создания</td>
                                <td><?=$date->format('d.m.Y H:i:s')?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">Уведомить меня если сумма на счету меньше :</td>
                                <td>
                                    <?=$formUser->field($user, 'cache_notification')->label(false)->textInput([
                                        'readonly'=>true,
                                        'class'=> 'col-md-6 col-sm-6 col-xs-6',
                                        'style' => 'border: none;padding-left: 0;'
                                    ])?> руб.
                                </td>
                                <td>
                                    <a id="cache_notification" style="cursor: pointer;" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
                                    <?= Html::a('<span class="col-md-12 col-sm-12 col-xs-12"><i class="fa fa-save"></i></span>','', ['class' => 'sub_link', 'id'=>"save_cache_notification", 'hidden'=>true])?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <? ActiveForm::end()?>
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
<script>
function myclick(param){
    document.getElementById('user-'+param).readOnly=false;
    document.getElementById('save_'+param).hidden= false;
    $('#user-'+param).focus();
}

$(document).on('click','.sub_link',function(e){
    e.preventDefault();
    $('#w0').yiiActiveForm('submitForm');
});
</script>