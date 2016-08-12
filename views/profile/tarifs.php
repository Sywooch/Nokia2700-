<?php

use app\models\Tarifs;
use app\models\WidgetSettings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Тарифный план';
$publ_tar = Tarifs::getActiveTarifs();
$arch_tar = Tarifs::getArchiveTarifs();

$tarif = new Tarifs;
$user = Yii::$app->user->identity->id;
?>

<section class="content-header">
    <h1>
        <?=$this->title?>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tarif" data-toggle="tab">Доступные тарифы</a></li>
                    <li class=""><a href="#archive-tarif" data-toggle="tab">Архив тарифов</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="tarif">
                        <div class="row">
                            <div class="clearfix visible-sm-block"></div>

                            <?php foreach($publ_tar as $pub):?>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-green">
                                            <div class="widget-user-image">
                                                <i class="icon ion-ios-telephone-outline"></i>
                                            </div>
                                            <!-- /.widget-user-image -->
                                            <h3 class="widget-user-username"><? echo $pub['tarif_name']?></h3>
                                        </div>
                                        <div class="box-footer no-padding">
                                            <?$tarifForm = ActiveForm::begin(['action'=>'/profile/user-tarif']);
                                            echo $tarifForm->field($tarif,'id')->hiddenInput(['value'=>$pub['id']])->label(false);
                                            echo $tarifForm->field($tarif,'user_id')->hiddenInput(['value'=>$user])->label(false);
                                            ?>
                                            <ul class="nav nav-stacked">
                                                <li><a href="#">Абонентская плата <span class="pull-right badge bg-green"><?=$pub['price']." "?> руб.</span></a></li>
                                                <li><a href="#">Стоимость минуты звонка <span class="pull-right badge bg-green"><?=$pub['minute_price']." "?> руб.</span></a></li>
                                                <li><a href="#">Стоимость одного смс <span class="pull-right badge bg-green"><?=$pub['sms_price']." "?> руб.</span></a></li>
                                            </ul>
                                            <a><?= Html::submitButton('Подключить', ['class' => 'btn btn-block btn-success']) ?></a>
                                            <?ActiveForm::end()?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>

                            <!-- /.col -->
                        </div>
                    </div>
                    <div class="tab-pane" id="archive-tarif">
                        <div class="row">
                            <div class="clearfix visible-sm-block"></div>
                            <?php foreach($arch_tar as $pub):?>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-red">
                                            <div class="widget-user-image">
                                                <i class="icon ion-ios-telephone-outline"></i>
                                            </div>
                                            <!-- /.widget-user-image -->
                                            <h3 class="widget-user-username"><?= $pub['tarif_name']?></h3>
                                        </div>
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
                                                <li><a href="#">Абонентская плата <span class="pull-right badge bg-blue"><?=$pub['price']." "?> руб.</span></a></li>
                                                <li><a href="#">Стоимость минуты звонка <span class="pull-right badge bg-blue"><?=$pub['minute_price']." "?> руб.</span></a></li>
                                                <li><a href="#">Стоимость одного смс <span class="pull-right badge bg-blue"><?=$pub['sms_price']." "?> руб.</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>