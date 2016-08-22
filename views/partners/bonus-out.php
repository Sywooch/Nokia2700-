<?php
use app\models\Paymant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;

$this->title = 'Вывод средств с бонусного счета';
$paymant = new Paymant;
/*echo "<pre>";
print_r($_POST);
echo "<pre>";*/
?>

<section class="content-header col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <h1><?=$this->title?></h1>
</section>

<section class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div>

        <div class="row">
            <div class="col-xs-8 col-sm-6 col-md-5 col-lg-4">
                <div class="form-group">
                    <?php $form = ActiveForm::begin();
                    $form->action = "bon-to-cache";
                    $items=array(
                        ""=>'Выберите желаемый способ получения',
                        "myCache"=> 'Перевести на основной счет',
                        "outCache"=>'Вывести на эл. кошелек (с дальнейшими инструкциями с Вами свяжется менеджер)',
                    );
                    ?>
                    <p><?= $form->field($paymant,'bonsum', ["template" => "<label> Введите сумму </label>\n{input}\n{hint}\n{error}"]) ?></p>
                    <p><?= $form->field($paymant,'bonpaywith', ["template" => "\n{input}\n{hint}\n{error}"])->dropDownList($items)?></p>
                    <p><input type="submit" class="btn btn-primary btn-block pay" value='Оформить заявку на вывод средств'></p>

                    <?php ActiveForm::end(); ?>
                    <!--<p><input type="text" id="paymant-summ" class="form-control" placeholder="Введите сумму" value=''></p>-->
                </div>
            </div>
        </div>

    </div>
</section>
