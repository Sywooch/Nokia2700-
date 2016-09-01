<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Paymant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;

$paymant = new Paymant;
$this->title = 'Пополнение баланса';

?>

<section class="content-header col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <h1><?=$this->title?></h1>
</section>

<section class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div>
		<div class="row">
			<div class="callout callout-info col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h4>Напоминание!</h4>
				Сумма оплаты не должна превышать 15 000 рублей
			</div>
		</div>
		<?php $form = ActiveForm::begin();
		$form->action = "pay-with";
		$items=array(
			""=>'Выберите способ оплаты',
			"Roboxchange"=> 'Робокасса',
			"InterKassa"=>'Интеркасса',
			"WalletOne"=>'Единый кошелек W1',
		);
		?>
		<div class="row">
			<div class="col-xs-8 col-sm-5 col-md-4 col-lg-3">
					<div class="form-group">
						<!--<p><?/*= $form->field($paymant,'user_id', ["type"=>"hidden", "value"=>"$model->user_id"]) */?></p>-->
						<p><?= $form->field($paymant,'summ', ["template" => "<label> Введите сумму </label>\n{input}\n{hint}\n{error}"]) ?></p>
						<p><?= $form->field($paymant,'paywith', ["template" => "\n{input}\n{hint}\n{error}"])->dropDownList($items)?></p>
						<!--<p><?/*=Html::activeDropDownList($paymant,'paywith',$items, 'class'=>'form-control btn-primary']);*/?></p>-->
						<p><input type="submit" class="btn btn-primary btn-block pay" value='Пополнить'></p>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
		<style>
			.pay-form {width: 20%;}
			.pay-form .btn {width: 100% !important;}
		</style>
	</div>
</section>