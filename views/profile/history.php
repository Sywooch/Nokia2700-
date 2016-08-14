<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;
use yii\grid\GridView;
use yii\bootstrap\Tabs;

$this->title = 'Звонки с виджетов';
?>

<section class="content-header">
	<h1><?= Html::encode($this->title)?></h1>
</section>

<section class="content">
	<?=Tabs::widget([
		'items' => [
			[
				'label' => 'Звонки с виджетов',
				'content' => 
					GridView::widget([
						'dataProvider' => $callProvider,
						'summary' => 'Показано <b>{end}</b> из <b>{totalCount}</b> элементов.',
				        'columns' => [
				            'widget_id',
				            'call_time',
				            'phone',
							'EndSide',
							'waiting_period_A',
							'waiting_period_B',
							'call_back_record_URL_A',
							'call_back_record_URL_B',
				            'call_back_cost',
				        ],
    			]),
				'active' => true,
			],
			[
				'label' => 'Сообщения с виджетов',
				'content' => 
					GridView::widget([
						'dataProvider' => $messageProvider,
						'summary' => 'Показано <b>{end}</b> из <b>{totalCount}</b> элементов.',
				        'columns' => [
				            'widget_id',
				            'name',
				            'email',
				            'message',
				        ],
    			]),
			]
		]
	]); ?>
</section>