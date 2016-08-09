<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<body class="hold-transition login-page">
    <?php if (Yii::$app->session->hasFlash('userRegistered')): ?>
        <div class="alert alert-success">
            <center>
                Спасибо за регистрацию, теперь вы можете войти, используя свои данные. 
                Для подтверждения аккаунта, перейдите по ссылке в письме.
            </center>
        </div>
    <?endif; ?>
    <?php if (Yii::$app->session->hasFlash('userActivated')): ?>
        <div class="alert alert-success">
            <center>
                Благодарим вас за подтверждение аккаунта, теперь вам доступны все функции в личном кабинете.
            </center>
        </div>
    <?endif; ?>
    <?php if (Yii::$app->session->hasFlash('notActivated')): ?>
        <div class="alert alert-error">
            <center>
                Ваш аккаунт не активирован, пройдите по ссылке в письме.
            </center>
        </div>
    <?endif; ?>
    <div class="wrapper">
        <div class="login-box">
            <div class="login-logo">Robax</div>
            <div class="login-box-body">
                <p class="login-box-msg">Вход</p>
                    <?php $form = ActiveForm::begin(); ?>
                        <div class="form-group has-feedback">
                            <input type="email" name="LoginForm[email]" class="form-control" placeholder="Почта">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="LoginForm[password]" class="form-control" placeholder="Пароль">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox" style="padding-left:15px">
                                <label>
                                  <input type="checkbox" name="LoginForm[rememberMe]"> Запомнить меня
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?= Html::a('Регистрация', ['/register'], ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                            </div>
                            <div class="col-xs-6">
                                <?= Html::submitButton('Вход', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</body>

