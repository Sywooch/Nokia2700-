<?php
use yii\helpers\Html;
use app\models\WidgetAnalytics;
use app\models\WidgetSettings;

$this->title = 'Виджеты';
?>
<section class="content-header">
    <h1><?=$this->title?><small>Предварительный просмотр</small></h1>
</section>
<script src="https://cdn.rawgit.com/zenorocha/clipboard.js/master/dist/clipboard.min.js"></script>
<style>
	.line{display:inline-block; width:29%; margin:1%;}
</style>
<section class="content">
    <?= Html::a('Добавить виджет', ['profile/add-widget'], ['class' => 'btn btn-block btn-success btn-lg line']) ?>
    <br>
    <?php
	if(isset($widgets)) 
	{
		foreach ($widgets as $widget) {
			(!($widget->hand_turn_on)) ? (WidgetAnalytics::saveHandSettings($widget->widget_id)) : '';?>
			<div class="line">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$widget->widget_site_url?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" title="Свернуть">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#Modal-<?=$widget->widget_id?>" title="Удалить">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body" style="display: block;">
                        <div class="box-header with-border"><p class="text-left" style="display:block; float:left"><?=WidgetSettings::checkSiteUsage($widget->widget_site_url, $widget->widget_key)?></p><p class="text-right">ID:<?=$widget->widget_id?></p></div><br/>
                        <div class="with-border"><?=Html::a('Редактировать', ['profile/update-widget/'.$widget->widget_id], ['class' => 'btn btn-primary btn-block'])?><br/></div>
                        <div class="with-border"><a class="btn btn-success btn-block get-widget" data-toggle="modal" data-target="#ModalCode-<?=$widget->widget_id?>">Код для вставки</a><br/></div>
                    </div>
                </div>
                <!--ModalDelete-->
                <div class="modal fade" id="Modal-<?=$widget->widget_id?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4>Удаление виджета.</h4>
                            </div>
                            <div class="modal-body">
                                <p>Вы действительно хотите удалить виджет <b>№<?=$widget->widget_id?></b></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                <?=Html::a('Удалить', ['profile/deletewidget/'.$widget->widget_id], ['class' => 'btn btn-danger'])?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--ModalCode-->
                <div class="modal fade" id="ModalCode-<?=$widget->widget_id?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Заголовок модального окна -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Код для вставки</h4>
                            </div>
                            <!-- Основное содержимое модального окна -->
                            <div class="modal-body" id="modal-code">
                                <?=WidgetSettings::getCode($widget->widget_key)?>
                            </div>
                            <!-- Футер модального окна -->
                            <div class="modal-footer">
                                <button class="btn-clipboard btn btn-success" data-clipboard-target="#modal-code">Скопировать в буфер обмена</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?}
	} else {?>
		У вас ещё нет виджетов <?=Html::a('Добавить', ['profile/add-widget'])?>
	<?}
	?>
</section>
<script>
    new Clipboard('.btn-clipboard'); // Не забываем инициализировать библиотеку на нашей кнопке
</script>