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
						'summary' => 'Показано <b>{end}</b> из <b>{totalCount}</b> звонков.',
				        'columns' => [
				            'widget_id',
				            'call_time',
				            'phone',
							'EndSide',
                            [
                                'attribute' => 'waiting_period_A',
                                'header' => '<a href="/profile/history?sort=waiting_period_A" data-sort="waiting_period_A">Время ожидания<br>Менеджера</a>',
                            ],
                            [
                                'attribute' => 'waiting_period_B',
                                'header' => '<a href="/profile/history?sort=waiting_period_B" data-sort="waiting_period_B">Время ожидания<br>Клиента</a>',
                            ],
                            [
                                'attribute' => 'call_back_record_URL_A',
                                'header' => '<a href="/profile/history?sort=call_back_record_URL_A" data-sort="call_back_record_URL_A">Запись разговора<br>Менеджера</a>',
                            ],
                            [
                                'attribute' => 'call_back_record_URL_B',
                                'header' => '<a href="/profile/history?sort=call_back_record_URL_B" data-sort="call_back_record_URL_B">Запись разговора<br>Клиента</a>',
                            ],
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
						'summary' => 'Показано <b>{end}</b> из <b>{totalCount}</b> сообщений.',
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