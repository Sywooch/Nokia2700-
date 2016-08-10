<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\assets\AppAsset;
use app\models\WidgetAnalytics;
use app\models\WidgetPendingCalls;
use app\models\WidgetSendedEmail;
use app\models\WidgetSettings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\WidgetCatching;

$this->title = 'Аналитика';

$widget = new WidgetAnalytics;

if (isset($_REQUEST['WidgetAnalytics']['widget_id'])) $widget->widget_id = $_REQUEST['WidgetAnalytics']['widget_id'];

$analytics = $widget::getCatchAnalytics($_REQUEST['WidgetAnalytics']['widget_id']);

$items = array();
$items[]='Все виджеты';
$widgetarr = $widget::getWidgets();
foreach ($widgetarr as $w)
{
    $items[$w['widget_id']] = $w['widget_site_url'];
}
?>
<section class="content-header">
    <h1>
        <?=$this->title?>
    </h1>
</section>

<!-- Main content -->
<section class="content">
<!--    <script src="//www.google-analytics.com/analytics.js"></script>-->
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12 col-sm-12">

            <div class="nav-tabs-custom">

                <ul class="nav nav-tabs">
<!--                    <li class="active"><a href="#activity" data-toggle="tab">Общая информация</a></li>-->
                    <li class="active"><a href="#analytics" data-toggle="tab">Статистика</a></li>
 <!--                   <li class=""><a href="#messages" data-toggle="tab">Графики</a></li>-->
                    <!--<li><a href="#settings" data-toggle="tab"><{profile.settings}></a></li>-->
                </ul>
                <div class="tab-content">

                    <div class="active tab-pane" id="analytics">
                        <div class="row">
                            <div class="clearfix visible-sm-block"></div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light-blue"><i class="icon ion-ios-telephone-outline"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Заявок на звонок</span>
                                        <span class="info-box-number"><?= WidgetPendingCalls::getCountRequireCalls()?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light-blue"><i class="icon ion-ios-email-outline"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Отправленных сообщений</span>
                                        <span class="info-box-number"><?= WidgetSendedEmail::getCountSendMails()?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light-blue"><i class="icon ion-ios-chatboxes-outline"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Количество чатов</span>
                                        <span class="info-box-number"><?= WidgetSendedEmail::getCountChats()?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light-blue">
                                        <i class="icon ion-ios-telephone-outline"></i>
                                        <i class="icon ion-ios-redo-outline"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">CALLBACK</span>
                                        <span class="info-box-number"><?= WidgetSendedEmail::getCountChats()?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <?php
                                $form = ActiveForm::begin();
                                echo $form->field($widget,'widget_id')->label(false)->dropDownList($items, array('selected' => $_REQUEST['WidgetAnalytics']['widget_id'], 'onchange'=>'this.form.submit()'));
                                ActiveForm::end();
                                ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="clearfix visible-sm-block"></div>
                            <? foreach($analytics as $key => $value):?>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <!--scroll down 100% page-->
                                    <div class="info-box-content-small">
                                        <span class="info-box-text"><!--<i class="fa fa-long-arrow-down"></i>--><?=$value['name']?></span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $value['shown'];?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $value['catch'] ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= $value['conversion']?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                    </div>
                                    <!-- /.info-box -->
                                </div>

                            <? endforeach;?>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages">
                       <!-- <?php
/*                        $stats = WidgetCatching::getStatistics();
                        */?>
                        <div>
                            <?php /*foreach($stats as $stat) {  }
                            */?>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Area Chart</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
                                    <div class="chart">
                                        <canvas id="areaChart" style="height: 250px; width: 510px;" width="510" height="250"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>

    </script>
</section>