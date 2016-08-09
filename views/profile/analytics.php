<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\WidgetAnalytics;
use app\models\WidgetPendingCalls;
use app\models\WidgetSendedEmail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\WidgetCatching;

$this->title = 'Аналитика';
$scroll = WidgetAnalytics::getUniqActions('scroll_down');
$active_more40 = WidgetAnalytics::getUniqActions('active_more40');
$other_page = WidgetAnalytics::getUniqActions('other_page');
$buttonPress = WidgetAnalytics::getUniqActions('form_activity');
$scroll2 = WidgetAnalytics::getCatched('scroll_down');
$active_more402 = WidgetAnalytics::getCatched('active_more40');
$other_page2 = WidgetAnalytics::getCatched('other_page');
$buttonPress2 = WidgetAnalytics::getCatched('form_activity');
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
                    <li class=""><a href="#messages" data-toggle="tab">Графики</a></li>
                    <!--<li><a href="#settings" data-toggle="tab"><{profile.settings}></a></li>-->
                </ul>
                <div class="tab-content">

                    <div class="active tab-pane" id="analytics">
                        <div class="row">
                            <div class="clearfix visible-sm-block"></div>
                            <!---->
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
                                <!--scroll down 100% page-->
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-long-arrow-down"></i>Скролл в конец страницы</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $scroll;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $scroll2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($scroll, $scroll2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <!--Go to other page-->
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-clone"></i>Переход на другую страницу</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $other_page;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $other_page2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($other_page, $other_page2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-hand-pointer-o"></i>Нажатие на кнопку</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $buttonPress;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $buttonPress2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?=(integer)WidgetAnalytics::conversion($buttonPress, $buttonPress2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-mouse-pointer"></i>Активность мыши</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $scroll;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $scroll2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($scroll, $scroll2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-hourglass-o"></i>Более 40с. на сайте</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $active_more40;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $active_more402 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($active_more40, $active_more402)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-hourglass-end"></i>Каждые 30с. после минуты</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $scroll;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $scroll2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($scroll, $scroll2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-hourglass"></i>Дольше среднего времени</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $scroll;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $scroll2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($scroll, $scroll2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-commenting-o"></i>Взаимодействие с формами</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $scroll;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $scroll2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($scroll, $scroll2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-file-word-o"></i>Посещение более 3-х страниц</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $scroll;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $scroll2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($scroll, $scroll2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-content-small">
                                    <span class="info-box-text"><i class="fa fa-file-word-o"></i>Переход на : URL Page</span>
                                    <span>
                                        <div class="anal-block-conv">
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">показов:</div>
                                                <div class="info-box-number"><?= $scroll;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">поймано:</div>
                                                <div class="info-box-number"><?= $scroll2 ;?></div>
                                            </div>
                                            <span><i class="icon ion-chevron-right"></i></span>
                                            <div class="anal-block-c">
                                                <div class="anal-block-c-title">конверсия:</div>
                                                <div class="info-box-number"><?= (integer)WidgetAnalytics::conversion($scroll, $scroll2)?>%</div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                    <div class="tab-pane" id="messages">
                        <?php
                        $stats = WidgetCatching::getStatistics();
                        ?>
                        <div>
                            <?php foreach($stats as $stat) {  }
                            ?>
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
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(function () {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var areaChart = new Chart(areaChartCanvas);

            var areaChartData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [
                    {
                        label: "Electronics",
                        fillColor: "rgba(210, 214, 222, 1)",
                        strokeColor: "rgba(210, 214, 222, 1)",
                        pointColor: "rgba(210, 214, 222, 1)",
                        pointStrokeColor: "#c1c7d1",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: [65, 59, 80, 81, 56, 55, 40]
                    },
                    {
                        label: "Digital Goods",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "#3b8bba",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: [28, 48, 40, 19, 86, 27, 90]
                    }
                ]
            };

            var areaChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true
            };

            //Create the line chart
            areaChart.Line(areaChartData, areaChartOptions);
        });
    </script>
</section>