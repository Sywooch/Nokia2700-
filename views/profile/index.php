<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Paymant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\WidgetCatching;

$this->title = 'Профиль пользователя';

Paymant::renewCache(Yii::$app->user->identity->id);

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
              <!--<li><a href="#settings" data-toggle="tab"><{profile.settings}></a></li>-->
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
								<td><?=$name?></td>
							</tr>
							<tr>
								<td>Почта пользователя</td>
								<td><?=$email?></td>
							</tr>
							<tr>
								<td>Телефон пользователя</td>
								<td><?=$phone?></td>
							</tr>
							<tr>
								<td>Дата создания</td>
                                <?php

                                ?>
								<td><?=$date->format('d.m.Y H:i:s');?></td>
							</tr>
						</tbody>
					</table>
	            </div>
            </div>
		  </div>
		</div>
	</div>
    </section>