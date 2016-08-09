<?php
//$this->registerJsFile('@web/plugins/jQuery/jQuery-2.2.0.min.js');

use app\models\WidgetAnalytics;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\WidgetSettings;
//$this->registerJsFile('@web/plugins/bootstrap/js/bootstrap.js');
$this->title = 'Виджеты';
/*echo "<pre>";
print_r($widgets);
echo "<pre>";*/
?>

<section class="content-header">
    <h1><?= Html::encode($this->title) ?><small>Предварительный просмотр</small></h1>
</section>
<style>
	.line{display:inline-block; width:29%; margin:1%;}
</style>
<?= Html::a('Добавить виджет', ['profile/add-widget'], ['class' => 'btn btn-block btn-success btn-lg line']) ?>
<section class="content">
	<?php
	if(isset($widgets)) 
	{
		foreach ($widgets as $widget) {
			(!($widget->hand_turn_on))? (WidgetAnalytics::saveHandSettings($widget->widget_id)):'';
			print '<div class="line">
	        		<div class="box box-warning">
	          			<div class="box-header with-border">
	            			<h3 class="box-title">'.$widget->widget_site_url.'</h3>

	            			<div class="box-tools pull-right">
	              				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	              				</button>
	            			</div>
	          			</div>
	          			<div class="box-body" style="display: block;">
	            			<div class="box-header with-border"><p class="text-left" style="display:block; float:left">'.WidgetSettings::checkSiteUsage($widget->widget_site_url, $widget->widget_key).'</p><p class="text-right">ID:'.$widget->widget_id.'</p></div><br/>
	            			<div class="with-border">'.Html::a('Редактировать', ['profile/update-widget/'.$widget->widget_id], ['class' => 'btn btn-primary btn-block']).'<br/></div>
	            			<div class="with-border"><a class="btn btn-primary btn-block get-widget" data-key="'.$widget->widget_key.'">Код для вставки</a><br/></div>
	          			</div>
	        		</div>
	      		</div>';
		}
	} else {
		print "У вас ещё нет виджетов.".Html::a('Добавить', ['profile/add-widget']);
	}
	?>
</section>

<div id="codeModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Код для вставки</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body" id="modal-code">
      </div>
      <!-- Футер модального окна -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
  $(".get-widget").click(function() {
    var url = "<?=Url::to('profile/get-widget-code/', true) ?>"+$(this).attr('data-key');
    $.post(
    url,
    function (result) {
        $('#modal-code').html(result);
    }
	);
	  $("#codeModal").modal('show');
  });
});
$.noConflict();
</script>