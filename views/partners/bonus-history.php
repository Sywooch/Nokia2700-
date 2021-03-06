<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;
use yii\grid\GridView;

$this->title = 'Бонусный счет';

$name = isset(Yii::$app->user->identity->name) ? Yii::$app->user->identity->name : '' ;
$bonuses = isset(Yii::$app->user->identity->bonus) ? Yii::$app->user->identity->bonus : '' ;
?>

<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive" src="/images/profile.png" style="width: 100%" alt="User profile picture">
                    <h3 class="profile-username text-center"><?=$name?></h3>
                    <!--<p class="text-muted text-center">Software Engineer</p>-->
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Бонусы</b> <a class="pull-right"><?=$bonuses?></a>
                        </li>
                    </ul>
                    <a href="<?=Url::to('bonus-out');?>" class="btn btn-primary btn-block"><b>Вывести бонусы</b></a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Общая информация бонусного счета</a></li>
                    <li class=""><a href="#bon-history" data-toggle="tab">История операций бонусного счета</a></li>
                </ul>
                <div class="tab-content" style="padding-bottom: 0;">
                    <div class="active tab-pane" id="activity">
                        <?= GridView::widget([
                            'dataProvider' => $dataProviderDesc,
                            'emptyText'=>'Тут пусто, и нам от этого грустно... <img src=/images/sad.gif border=0>',
                            'columns' => [
                                'client',
                                'dateFormat',
                                'client_paid_sum',
                                'payment',
                                'description',
                            ],
                        ]); ?>
                    </div>
                    <div class="tab-pane" id="bon-history">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'emptyText'=>'Тут пусто, и нам от этого грустно... <img src=/images/sad.gif border=0>',
                            'columns' => [
                                'order_num',
                                'dateFormat',
                                'typeFormat',
                                'payment',
                                'payStatus',
                                'description'
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>