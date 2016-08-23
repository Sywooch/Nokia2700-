<?php

use app\models\WidgetPendingCalls;
use app\models\WidgetSendedEmail;
?>

<section class="content">
<!--    <script src="//www.google-analytics.com/analytics.js"></script>-->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="nav-tabs-custom">
                <!--<ul class="nav nav-tabs">
                    <li class="active"><a href="#analytics" data-toggle="tab">Статистика</a></li>
                    <li class=""><a href="#chart_div" data-toggle="tab">Статистика</a></li>
                </ul>-->
                <div class="tab-content">
                    <div class="active tab-pane" id="analytics">
                        <div class="row">
                            <div class="clearfix visible-sm-block"></div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light-blue"><i class="icon ion-ios-telephone-outline"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Заявок на звонок</span>
                                        <span class="info-box-number"><?=WidgetPendingCalls::getCountRequireCalls()?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-light-blue"><i class="icon ion-ios-email-outline"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Отправленных сообщений</span>
                                        <span class="info-box-number"><?= WidgetSendedEmail::getCountSendMails()?></span>
                                    </div>
                                </div>
                            </div>
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
                                </div>
                            </div>
                         </div>
                    </div>
                   <!-- <div class="tab-pane" id="chart_div">

                    </div>-->
                </div>
            </div>
        </div>
    </div>
</section>