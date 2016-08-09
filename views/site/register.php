<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
                        <input type="text" class="form-control" name="User[phone]" placeholder="Телефон">
                        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="checkbox icheck">
                                <label>
                                    <center>
                                        <input type="checkbox"> Я согласен(на) с <a href="#">Условиями конфиденциальности</a>
                                    </center>
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <center>
                                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                            </center>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
                <br/>
                <center><?= Html::a('Я уже зарегистрирован', ['/login']) ?></center>

            </div>
        </div>
    </div>
</body>