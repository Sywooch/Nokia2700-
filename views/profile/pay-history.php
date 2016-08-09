<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;
use yii\grid\GridView;

$this->title = 'История баланса';
?>

<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>

<section class="content">
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'dateFormat',
            'typeFormat',
            'payment',
            'payStatus',
        ],
    ]); ?>
</section>