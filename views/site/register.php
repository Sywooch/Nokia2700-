<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use \app\models\User;
use yii\jui\AutoComplete;
$user = new User();
?>

<div class="hold-transition register-page">
    <div class="wrapper">
        <div class="register-box">
            <div class="register-box-body">
                <p class="login-box-msg">Регистрация</p>
                <?php $form = ActiveForm::begin(); ?>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="User[email]" placeholder="Почта">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="User[pass]" placeholder="Пароль">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="User[name]" placeholder="Имя">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" style="position: relative">
                        <?=MaskedInput::widget([
                            'name' => 'User[phone]',
                            'mask' => '+7(999)999-99-99',
                            'options' => [
                                'class' => 'form-control widget_phone',
                                'style' => 'padding-left: 45px',
                                'autocomplete' => 'off',
                                'data-required' => true,
                                'placeholder' => '+7(___)___-__-__'
                            ]
                        ]);?>
                        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                        <button class="flag-select dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="glyphicon bfh-flag-RU"></i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                            <li onclick="countryChange('RU', $(this));"><i class="glyphicon bfh-flag-RU"></i> Россия</li>
                            <li onclick="countryChange('BY', $(this));"><i class="glyphicon bfh-flag-BY"></i> Белорусия</li>
                            <li onclick="countryChange('UA', $(this));"><i class="glyphicon bfh-flag-UA"></i> Украина</li>
                            <li onclick="countryChange('US', $(this));"><i class="glyphicon bfh-flag-US"></i> США</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="checkbox icheck">
                                <label class="text-center">
                                    <input type="checkbox"> Я согласен(на) с <a href="#">Условиями конфиденциальности</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-12 text-center">
                            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
                <br/>
                <div class="text-center">
                    <?= Html::a('Я уже зарегистрирован', ['/login']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function countryChange(lang, element) {
    ul = element.parent('ul');
    id_button = ul.attr('aria-labelledby');
    button = ul.siblings('button');
    input = ul.siblings('input');
    switch (lang) {
        case 'RU': {
            button.html('<i class="glyphicon bfh-flag-RU"></i><span class="caret">');
            input.val('');
            input.attr('placeholder', '+7(___)___-__-__');
            input.inputmask('+7(999)999-99-99');
            break;
        }
        case 'BY': {
            button.html('<i class="glyphicon bfh-flag-BY"></i><span class="caret">');
            input.val('');
            input.attr('placeholder', '+375(___)___-__-__');
            input.inputmask('+375(999)999-99-99');
            break;
        }
        case 'UA': {
            button.html('<i class="glyphicon bfh-flag-UA"></i><span class="caret">');
            input.val('');
            input.attr('placeholder', '+380(___)___-__-__');
            input.inputmask('+380(999)999-99-99');
            break;
        }
        case 'US': {
            button.html('<i class="glyphicon bfh-flag-US"></i><span class="caret">');
            input.val('');
            input.attr('placeholder', '+1(___)___-__-__');
            input.inputmask('+1(999)999-99-99');
            break;
        }
    }
}
</script>