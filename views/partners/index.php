<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Партнёрская программа';
?>
<section class="content-header">
    <h1><?=$this->title?> <small>Общая информация</small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body text-center">
                    <h3>Партнёрская ссылка: <span class="text-primary">http://<?=$_SERVER['HTTP_HOST']?>/register?ref=<?=Yii::$app->user->id?></span></h3>
                    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">Приглашение по Email</button>
                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <?php $form = ActiveForm::begin([
                                    'method' => 'post',
                                    'action' => 'partners/sendmail',
                                ]); ?>
                                <div class="modal-header text-left">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Приглашение по Email</h4>
                                </div>
                                <div class="modal-body text-left">
                                    <p>Перечислети email'ы через запятую:</p>
                                    <textarea class="form-control" rows="6" name="mails"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
                                </div>
                                <?php ActiveForm::end()?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <h4>
                        За привлечённых партнёров Вы получаете <span class="text-bold text-success">30%</span> со всех пополнений.
                        <br>
                        За партнёров привлечённых вашими партнёрами Вы получаете <span class="text-bold text-success">10%</span> со всех пополнений.
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <h4>Партнёры которых пригласили Вы.</h4>
                </div>
                <div class="box-footer">
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderLeft,
                        'summary' => 'Показано <b>{end}</b> из <b>{totalCount}</b> элементов.',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'user_id',
                            'name:ntext',
                            'create_at',
                            'partners_count',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <h4>Партнёры ваших партнёров.</h4>
                </div>
                <div class="box-footer">
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderRight,
                        'summary' => 'Показано {end} из {totalCount} элементов.',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'user_id',
                            'name:ntext',
                            'create_at',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</section>