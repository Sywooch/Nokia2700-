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
?>

<section class="content-header">
    <h1><?= Html::encode($this->title) ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Общая информация бонусного счета</a></li>
                    <li class=""><a href="#bon-history" data-toggle="tab">История операций бонусного счета</a></li>
                </ul>
                <div class="tab-content" style="padding-bottom: 0;">
                    <div class="active tab-pane" id="activity">

                    </div>
                    <div class="tab-pane" id="bon-history">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                'order_num',
                                'dateFormat',
                                'typeFormat',
                                'payment',
                                'payStatus',
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>