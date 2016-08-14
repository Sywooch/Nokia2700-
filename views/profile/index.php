<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Paymant;
use app\models\Tarifs;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\WidgetCatching;

$this->title = 'Профиль пользователя';

$cur_tarif = Tarifs::getUserTarif(Yii::$app->user->identity->id)['0'];

$user = User::findIdentity(Yii::$app->user->identity->id);

/*echo '<pre>';
print_r($_POST);
echo '</pre>';*/

?>
<section class="content-header">
    <h1>
        <?=$this->title?>
    </h1>
</section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

            <!--<img class="profile-user-img img-responsive img-circle" src="/dist/img/user4-128x128.jpg" alt="User profile picture">-->

                <?php
                $name = isset(Yii::$app->user->identity->name) ? Yii::$app->user->identity->name : '' ;
                $cache = isset(Yii::$app->user->identity->cache) ? Yii::$app->user->identity->cache : '' ;
                $email = isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : '' ;
                $id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : '' ;
                $phone = isset(Yii::$app->user->identity->phone) ? Yii::$app->user->identity->phone : '' ;
                $date = isset(Yii::$app->user->identity->create_at) ? new DateTime(Yii::$app->user->identity->create_at) : new DateTime();
                $notif = isset(Yii::$app->user->identity->name) ? Yii::$app->user->identity->cache_notification : '' ;
                ?>

              <h3 class="profile-username text-center"><?=$name?></h3>

              <!--<p class="text-muted text-center">Software Engineer</p>-->

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Баланс</b> <a class="pull-right"><?=$cache?></a>
                </li>
              </ul>

              <a href="<?=Url::to('/profile/pay');?>" class="btn btn-primary btn-block"><b>Пополнить счёт</b></a>
            </div>
            <!-- /.box-body -->
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Общая информация</a></li>
                <li class=""><a href="#tarif" data-toggle="tab">Текущий тарифный план</a></li>
              <!--<li><a href="#settings" data-toggle="tab">Настройки профиля</a></li>-->
            </ul>
            <div class="tab-content">
	            <div class="active tab-pane" id="activity">
                    <? $formUser = ActiveForm::begin(['action'=>'/profile/update-user'])?>
					<table class="table">
						<tbody>
							<tr>
								<td>ID пользователя</td>
								<td><?/*=$id*/?><?=$formUser->field($user, 'id')->label(false)->textInput(['readonly'=>true, 'value'=>$id, 'class'=> 'col-md-12 col-sm-12 col-xs-12'])?></td>
							</tr>
							<tr>
								<td>Имя пользователя</td>
								<td><?/*=$name*/?><?=$formUser->field($user, 'name')->label(false)->textInput(['readonly'=>true, 'value'=>$name, 'class'=> 'col-md-12 col-sm-12 col-xs-12'])?></td>
                                <td>
                                    <a id="name" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
                                    <?= Html::a('<span class="col-md-12 col-sm-12 col-xs-12"><i class="fa fa-save"></i></span>','', ['class' => 'sub_link', 'id'=>"save_name", 'hidden'=>true])?>
                                </td>
							</tr>
							<tr>
								<td>Почта пользователя</td>
								<td><?/*=$email*/?><?=$formUser->field($user, 'email')->label(false)->textInput(['readonly'=>true, 'value'=>$email, 'class'=> 'col-md-12 col-sm-12 col-xs-12'])?></td>
                                <td>
                                    <a id="email" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
                                    <?= Html::a('<span class="col-md-12 col-sm-12 col-xs-12"><i class="fa fa-save"></i></span>','', ['class' => 'sub_link', 'id'=>"save_email", 'hidden'=>true])?>
                                </td>
							</tr>
							<tr>
								<td>Телефон пользователя</td>
								<td><?/*=$phone*/?><?=$formUser->field($user, 'phone')->label(false)->textInput(['readonly'=>true, 'value'=>$phone, 'class'=> 'col-md-12 col-sm-12 col-xs-12'])?></td>
                                <td>
                                    <a id="phone" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
                                    <?= Html::a('<span class="col-md-12 col-sm-12 col-xs-12"><i class="fa fa-save"></i></span>','', ['class' => 'sub_link', 'id'=>"save_phone", 'hidden'=>true])?>
                                </td>
							</tr>
							<tr>
								<td>Дата создания</td>
								<td><?/*=$date->format('d.m.Y H:i:s');*/?><?=$formUser->field($user, 'date')->label(false)->textInput(['readonly'=>true, 'value'=>$date->format('d.m.Y H:i:s'), 'class'=> 'col-md-12 col-sm-12 col-xs-12'])?></td>
							</tr>
                            <tr>
                                <td>Уведомить меня если сумма на счету меньше :</td>
                                <td><?/*=$notif." ";*/?><?=$formUser->field($user, 'cache_notification')->label(false)->textInput(['readonly'=>true, 'value'=>$notif, 'class'=> 'col-md-6 col-sm-6 col-xs-6'])?> руб.</td>
                                <td>
                                    <a id="cache_notification" onclick="myclick(this.id);"><span class='col-md-12 col-sm-12 col-xs-12'><i class="fa fa-edit"></i></span></a>
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
                <div class="tab-pane" id="settings">
                    <div class="row">
                        <div class="col-md-7 col-sm-6 col-xs-12">

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
    }

    $(document).on('click','.sub_link',function(e){
        e.preventDefault();
        $('#w0').yiiActiveForm('submitForm');
    });

    function mysave(val)
    {

    }
</script>