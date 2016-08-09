<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

$this->registerJsFile('@web/plugins/bootstrap/js/bootstrap.min.js');
use app\models\User;
use yii\bootstrap\Html;
use yii\helpers\Url;

?>

<div class="content">
    <section class="content col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div>
            <div class="line-time">
                <div class="alert alert-danger " role="alert">
                    Что то пошло не так...
                </div>
            </div>
            <div>
                <div class="line-time">
                    <?= Html::button('Вернуться в профиль', ['class' => 'btn btn-block btn-info']) ?>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('.btn-info').click(function(){
            window.location.href='/profile/';
        });
    </script>
    <?


    ?>
</div>
