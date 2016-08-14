<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<body class="hold-transition register-page">
    <div class="wrapper">
        <div class="register-box">
            <div class="register-box-body">
                <p class="login-box-msg">Регистрация</p>
                <?php $form = ActiveForm::begin(); ?>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="User[name]" placeholder="Имя">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="User[pass]" placeholder="Пароль">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="User[email]" placeholder="Почта">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        
                        <input type="text" class="form-control" name="User[phone]" autocomplete="off" placeholder="+7(___)___-__-__">
                        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
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
</body>
<script>
    helper.setMask($("[name='User[phone]']")[0],'+7(999)999-99-99');
</script>