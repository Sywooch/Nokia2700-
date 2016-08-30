<?php
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\WidgetTemplateNotification;
use yii\widgets\MaskedInput;

$this->registerCssFile("http://bootstrapformhelpers.com/assets/css/bootstrap-formhelpers.min.css");
$this->registerCss("
    .flag-select {
        background: #fff;
        border: none;
        position: absolute;
        top: 5px;
        left: 1px;
        z-index: 100;
    }
    .dropdown-menu {
        min-width: 110px!important;
        padding-left: 6px;
    }
    .dropdown-menu li {
        cursor: pointer;
    }
");

$path = '/files/images/desktop/';
$path2 = '/files/images/mobile/';
$this->title = 'Добавить виджет';
?>
<section class="content-header">
	<h1><?= Html::encode($this->title) ?></h1>
</section>

<!-- Main content -->
<section class="content">
	<!-- Small boxes (Stat box) -->
	<?php $form = ActiveForm::begin(); ?>
	<div class="">

		<div class="form-group bordered">
			<div class="form-group">
				<label>Общие настройки</label>
			</div>
			<div class="form-group">
				<input class="form-control" name="widget_site_url" type="text" placeholder="URL сайта (без http(s))" onblur="siteChange(this.value);" value="<?=$model->widget_site_url?>">
			</div>
			<div class="form-group">
				<select class="form-control" name="widget_sound">
					<option value="1">Включить звук</option>
					<option value="0">Выключить звук</option>
				</select>
			</div>
			<label>Цветовая схема <small>(выберете схему)</small></label><br>
			<ul class="color_theme_list__ul">
				<li class="color_theme_list__ul__item" style="border-radius: 30px !important; background: rgba(204, 204, 204, 0.95);color:#333;"></li>
				<li class="color_theme_list__ul__item" style="border-radius: 30px !important; background: black;color:#fff;"></li>
			</ul>
			<select class="form-control" name="widget_theme_color" style="display: none;">
				<option value="1">Светлая тема</option>
				<option value="0">Тёмная тема</option>
			</select>
			<label>Цвет кнопки</label><br>
			<div class="input-group my-colorpicker colorpicker-element" style="width: 35%;">
				<input type="text" name="widget_button_color" class="form-control"  placeholder="Цвет кнопки" value="<?=$model->widget_button_color?>">
				<div class="input-group-addon">
					<i></i>
				</div>
			</div>
			<script type="text/javascript">
				$("[name='widget_button_color']").change(function(){
					$("#open-button").style.background = '#bbb';
				});
			</script>
		</div>
		<div class="form-group col-sm-6 bordered" style="width: 65%;">
			<label>Расположение виджета</label><br>
			<div class="widget-position">
				<div class="widget-top-position">
				</div>
				<div class="widget-body-position" style="width: 600px;height: 400px;">
					<div class="robax-widget-open-button" id="open-button" style="z-index: 100;background: rgba(0, 175, 242,0.6); border-radius: 100%; position: relative; top:90%; left:94%; width: 38px; height: 38px;">
						<?=Html::img('@web'.'/widget-front/img/phone-icon.png',['class' => "phone", 'style' => 'margin: 9px; width: 21px; height: 21px;']); ?>
					</div>
					<img style="width: 600px;height: 400px;position: relative;top: -40px;" id="screenDesktop" />
				</div>
				<div class="clear"></div>
				<div class="widget-left-position">
				</div>
				<input name="witget-button-top" type="hidden">
				<input name="witget-button-left" type="hidden">
			</div>
		</div>
		<div class="form-group col-sm-6 bordered" style="width: 31%;">
			<label>Расположение виджета (моб-ая версия)</label><br>
			<div class="widget-position-mob">
				<div class="widget-top-position-mob">
				</div>
				<div class="widget-body-position-mob" style="width: 225px;height:400px;">
					<div class="robax-widget-open-button-mob" id="open-button-mob" style="z-index: 100;background: rgba(0, 175, 242,0.6); border-radius: 100%; position: relative; top:91%; left:85%; width: 34px; height: 34px;">
						<?=Html::img('@web'.'/widget-front/img/phone-icon.png',['class' => "phone", 'style' => 'margin: 9px; width: 18px; height: 18px;']); ?>
					</div>
					<img style="width: 225px;height: 400px;position: relative;top: -35px;" id="screenMobile" />
				</div>
				<div class="clear"></div>
				<div class="widget-left-position-mob">
				</div>
				<input name="witget-button-top-mob" type="hidden">
				<input name="witget-button-left-mob" type="hidden">
			</div>
		</div>
		<div class="clear"></div>
		<div class="bordered">
			<label>Настройка поведенческих факторов</label><br>
			<div class="form-group">
				<div style="margin: 10px 0;">
					<div style="display: inline-block;">
						<?echo $form->field($model, 'hand_turn_on')->widget(SwitchInput::classname(), [
							'options'=>[
								'onchange'=>'openMarks();',
							]
						])->label(false);?>
					</div>
					<div style="display: inline-block">
						<span style="margin: 0 15px;">если настройка выключена, то виджет автоматически настраивает поведенческие факторы под ваш сайт.</span>
					</div>
				</div>
			</div>
			<div id="openMarks" class="marks-body" <?= ($model->hand_turn_on)? 'style="display: block;':'style="display: none;'?>">
			<?$items = [
				0 => '0 баллов',
				1 => '1 балл',
				2 => '2 балла',
				3 => '3 балла',
				4 => '4 балла',
				5 => '5 баллов',
				6 => '6 баллов',
				7 => '7 баллов',
				8 => '8 баллов',
				9 => '9 баллов',
				10 => '10 баллов',
			];?>
			<table>
				<tr>
					<td style="padding-right:10px">Переход на другую страницу</td>
					<td style="padding-right:15px"><?=Html::dropDownList('other_page',0,$items);?></td>
					<td>Посещение более 3х страниц сайта</td>
					<td><?=Html::dropDownList('sitepage3_activity',0,$items);?></td>
				</tr>
				<tr>
					<td>Скролл вниз(за 100% страницы)</td>
					<td><?=Html::dropDownList('scroll_down',0,$items);?></td>
					<td>Дольше среднего времени на сайте</td>
					<td><?=Html::dropDownList('more_avgtime',0,$items);?></td>
				</tr>
				<tr>
					<td>Активность на сайте более 40 сек.</td>
					<td><?=Html::dropDownList('active_more40',0,$items);?></td>
					<td>За каждые 30 сек., после 1 мин.</td>
					<td><?=Html::dropDownList('moretime_after1min',0,$items);?></td>
				</tr>
				<tr>
					<td>Интенсивность движения мышки</td>
					<td><?=Html::dropDownList('mouse_intencivity',0,$items);?></td>
					<td>Взаимодействие с формами</td>
					<td><?=Html::dropDownList('form_activity',0,$items);?></td>
				</tr>
				<tr>
					<td style="padding-right:10px"></td>
					<td></td>
					<td style="padding-right:10px">Поведение, похожее на других клиентов</td>
					<td><?=Html::dropDownList('client_activity',$marks->client_activity,$items);?></td>
				</tr>
			</table>
			<label>Посещение конкретной страницы или раздела сайта</label>
			<br>
			<div id="pages_block">
				<?php
				$sitePageList = json_decode($marks->site_pages_list);
				$sitePageList = explode(';', $marks->site_pages_list);
				$num = count($sitePageList)-1;
				unset($sitePageList[$num]);
				$count_site_pages = count($sitePageList);
				for($i=1; $i<=$count_site_pages; $i++)
				{
					$values = explode('*',$sitePageList[$i-1]);
					echo '<span class="phone">Cсылка №'.$i.'</span>
                <div class="input-group">
                <div class="input-group-addon">
                <i class="fa fa-link"></i>
                </div>
                <input type="text" class="form-control widget_url" name="site_page_'.$i.'" data-required="true" value="'.$values[0].'"></div>'
						.Html::dropDownList('select_site_page_'.$i,$values[1],$items,['class' => 'form-control']).'<br>';
				}
				?>
			</div>
			<br>
			<input type="hidden" name="count_pages" value="<?=$count_site_pages?>">
			<div class="input-group">
				<button class="sitepage_more btn">Добавить еще одну страницу</button>
			</div>
			<br>
		</div>
	</div>
	<div class="clear"></div>
	<!--<div class="bordered">
        <label>УТП</label>
        <br>
        <div class="form-group">
            <div style="margin: 10px 0;">
                <div style="display: inline-block;">
                    <?/*echo $form->field($model, 'utp_turn_on')->widget(SwitchInput::classname(), [
                        'options'=>[
                            'onchange'=>'openUtp();',
                        ]
                    ])->label(false);*/?>
                </div>
                <div style="display: inline-block">
                    <span style="margin: 0 15px;">уникальное торговое предложение, выводится при попытки уйти с сайта</span>
                </div>
            </div>
        </div>
        <div id="openUtp" class="utp-body" <?/*= ($model->utp_turn_on)? 'style="display: block;':'style="display: none;'*/?>">
            <div class="callout callout-info"><p>Максимальный размер изображения: 800 x 800</p></div>
            <input maxlength="500" id="url_utp_img" name="utp-img-url" type="text" class="form-control" placeholder="URL изображения" value="<?/*=$model->utp_img_url*/?>">
            <br>
            <label>Цвет кнопки</label>
            <div class="input-group  colorpicker-element" style="width: 400px;">
                <input type="text" name="utm-button-color" class="form-control utm-button-color my-colorpicker"  placeholder="Цвет кнопки" value="<?/*=$model->utm_button_color*/?>">
            </div>
            <br>
            <?/*$width = 0;$height = 0;
            if ($model->utp_img_url) list($width, $height, $type, $attr) = getimagesize($model->utp_img_url);*/?>
            <div class="utp-exampl" style="background: url(<?/*=$model->utp_img_url*/?>);background-repeat: no-repeat;width: <?/*=$width*/?>px;height: <?/*=$height*/?>px;">
                <div class="utm-closed"></div>
                <div class="utp-form" style="<?/*=$model->widget_utp_form_position*/?>">
                    <div class="line"><input type="text" placeholder="Введите ваш телефон" /></div>
                    <div class="line"><button style="background: <?/*=$model->utm_button_color*/?>;">Отправить</button></div>
                </div>
            </div>
            <img class="utp-img-exampl"  style="display: none;"/>
            <?/*$pos = explode(';', $model->widget_utp_form_position)*/?>
            <input name="widget-utp-form-left" style="display: none;" value="<?/*=$pos[0]*/?>;"/>
            <input name="widget-utp-form-top" style="display: none;" value="<?/*=$pos[1]*/?>;"/>
        </div>
    </div>-->
	<div class="bordered">
		<label>Черный список </label> <small>(укажите номера, на которые виджет не будет звонить)</small>
		<br>
		<div id="black_list_block">
			<?php
			$blackList = explode(';', $model->black_list);
			$num = count($blackList)-1;
			unset($blackList[$num]);
			$count_black_list = count($blackList);
			for($i=1; $i<=$count_black_list; $i++)
			{?>
				<span class="phone">Телефон №<?=$i?></span>
				<div class="input-group">
					<?=MaskedInput::widget([
						'name' => 'black_list_number_'.$i,
						'value' => $blackList[$i-1],
						'mask' => '+7(999)999-99-99',
						'options' => [
							'class' => 'form-control widget_phone',
							'style' => 'padding-left: 45px;',
							'data-required' => true,
							'placeholder' => '+7(___)___-__-__'
						]
					]);?>
					<button class="flag-select dropdown-toggle" type="button" id="dropdownMenu_<?=$i?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<?php
						$flag = 'RU';
						$phone = explode('(', $blackList[$i-1])[0];
						switch ($phone) {
							case '+7' : $flag = 'RU';break;
							case '+375' : $flag = 'BY';break;
							case '+380' : $flag = 'UA';break;
							case '+1' : $flag = 'US';break;
						}
						?>
						<i class="glyphicon bfh-flag-<?=$flag?>"></i><span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu_<?=$i?>">
						<li onclick="countryChange('RU', $(this));"><i class="glyphicon bfh-flag-RU"></i> Россия</li>
						<li onclick="countryChange('BY', $(this));"><i class="glyphicon bfh-flag-BY"></i> Белорусия</li>
						<li onclick="countryChange('UA', $(this));"><i class="glyphicon bfh-flag-UA"></i> Украина</li>
						<li onclick="countryChange('US', $(this));"><i class="glyphicon bfh-flag-US"></i> США</li>
					</ul>
				</div>
			<?}?>
		</div>
		<br>
		<input type="hidden" name="count_black_list" value="<?=$count_black_list?>">
		<div class="input-group">
			<button class="blacklist_more btn">Добавить еще один номер</button>
		</div>
		<br>
	</div>
	<div class="bordered">
		<label>Настройки Цели </label><small>(помогут ослеживать конверсию виджета, инструкция)</small>
		<br>
		<div class="form-group">
			<input class="form-control" name="widget_name" type="text" placeholder="Имя Цели" value="<?$model->widget_name?>">
		</div>
		<div class="form-group">
			<input class="form-control" name="widget_yandex_metrika" type="text" placeholder="Yandex Metrika" value="<?$model->widget_yandex_metrika?>">
		</div>
		<div class="form-group">
			<div style="margin: 10px 0;">
				<div style="display: inline-block;">
					<?echo $form->field($model, 'widget_google_metrika')->widget(SwitchInput::classname(), [])->label(false);?>
				</div>
				<div style="display: inline-block">
					<span style="margin: 0 15px;">Если на сайте подключено <b>Google Analytics</b></span></div>
			</div>
		</div>
	</div>
	<div class="bordered">
		<label>Настройки сообщений виджета</label>
		<div class="form-group">
			<div style="margin: 10px 0;">
				<div style="display: inline-block;">
					<?echo $form->field($model, 'widget_messages_on')->widget(SwitchInput::classname(), [
						'options'=>[
							'onchange'=>'openMessages();',
						]
					])->label(false);?>
				</div>
				<div style="display: inline-block">
					<span style="margin: 0 15px;">если настройка выключена, то используются шаблоны разработанные нашим отделом маркетинга.</span></div>
			</div>
		</div>
		<br>
		<div id="openMessages" class="messages-body" <?= ($model->widget_messages_on)? 'style="display: block;"':'style="display: none;"'?>>
			<?/*if ($widgetTemplate) {
			foreach ($widgetTemplate as $key => $value) {*/?><!--
				<div>
					<div style="display: inline-block;">
						<?/*echo SwitchInput::widget([
							'name'=>'template[change]['.$value['id_template'].']',
							'value'=>$value['status'] ? 1 : 0,
							'options'=>[
								'onchange'=>'openBlock('.$value['id_template'].');',
							]
						]);*/?>
					</div>
					<div style="display: inline-block;">
						<?/*$widetTemplate = WidgetTemplateNotification::findOne(['id_template' => $value['id_template']]);*/?>
						<span style="margin: 0 15px;"><?/*=$widetTemplate->name*/?></span>
					</div>
					<div id="openBlock-<?/*=$value['id_template']*/?>" style="<?/*=$value['status'] ? 'display: block;' : 'display: none;'*/?>margin-bottom: 30px;">
						<?/*if ($value['param']) {*/?>
							<div class="form-group">
								<span>Каждые</span>&nbsp;&nbsp;&nbsp;<input type="number" name="template[param][]" min="0" max="60" value="<?/*=$value['param']*/?>"/>
							</div>
						<?/*} else {*/?>
							<input type="text" style="display: none;" name="template[param][]"/>
						<?/*}*/?>
						<textarea name="template[description][]" class="form-control"><?/*=$value['description']*/?></textarea>
						<input type="text" style="display: none;" name="template[id][]" value="<?/*=$value['id_template']*/?>"/>
					</div>
				</div>
			--><?/*}
		} else {*/
			foreach ($widgetTemplate as $key => $value) {?>
				<div>
					<div style="display: inline-block;">
						<?echo SwitchInput::widget([
							'name'=>'template[change]['.$value['id_template'].']',
							'value'=>0,
							'options'=>[
								'onchange'=>'openBlock('.$value['id_template'].');',
							],
						]);?>
					</div>
					<div style="display: inline-block;">
						<span style="margin: 0 15px;"><?=$value['name']?></span>
					</div>
					<div id="openBlock-<?=$value['id_template']?>" style="display: none;margin-bottom: 30px;">
						<?if ($value['param']) {?>
							<div class="form-group">
								<span>Каждые</span>&nbsp;&nbsp;&nbsp;<input type="number" name="template[param][]" min="0" max="60" value="<?=$value['param']?>"/>
							</div>
						<?} else {?>
							<input type="text" style="display: none;" name="template[param][]"/>
						<?}?>
						<textarea name="template[description][]" class="form-control"><?=$value['description']?></textarea>
						<input type="text" style="display: none;" name="template[id][]" value="<?=$value['id_template']?>"/>
					</div>
				</div>
			<?}
		/*}*/?>
		</div>
	</div>
	<div class="bordered">
		<label>Настройки уведомлений</label>
		<br>
		<div id="emails_block">
			<?php
			$mails = explode(';', $model->widget_user_email);
			$num = count($mails)-1;
			unset($mails[$num]);
			$count_mails = count($mails);
			for($i=1; $i<=$count_mails; $i++)
			{?>
				<span class="phone">Ваша эл-почта</span>
				<div class="input-group">
					<div class="input-group-addon">
						<b>@</b>
					</div>
					<input type="text" class="form-control" name="widget_user_email_<?=$i?>" placeholder="Email" data-required="true" value="<?=$mails[$i-1]?>">
				</div>
			<?}
			?>
		</div>
		<br>
		<input type="hidden" name="count_emails" value="<?=$count_mails?>">
		<div class="input-group">
			<button class="email_more btn">Добавить еще один email</button>
		</div>
		<br>
		<div id="phones_block">
			<?php
			$phones = explode(';', $model->widget_phone_numbers);
			$num = count($phones)-1;
			unset($phones[$num]);
			$count_phones = count($phones);
			for($i=1; $i<=$count_phones; $i++)
			{?>
				<span class="phone">Телефон №<?=$i?> (определяется при звонке клиенту)</span>
				<div class="input-group">
					<div class="col-md-6">
					<?=MaskedInput::widget([
						'name' => 'widget_phone_number_'.$i,
						'value' => $phones[$i-1],
						'mask' => '+7(999)999-99-99',
						'options' => [
							'class' => 'form-control widget_phone',
							'style' => 'padding-left: 45px; display: inline-block;',
							'data-required' => true,
							'placeholder' => '+7(___)___-__-__'
						]
					]);?>
					<button class="flag-select dropdown-toggle" type="button" id="dropdown2Menu_<?=$i?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<?php
						$flag = 'RU';
						$phone = explode('(', $phones[$i-1])[0];
						switch ($phone) {
							case '+7' : $flag = 'RU';break;
							case '+375' : $flag = 'BY';break;
							case '+380' : $flag = 'UA';break;
							case '+1' : $flag = 'US';break;
						}
						?>
						<i class="glyphicon bfh-flag-<?=$flag?>"></i><span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdown2Menu_<?=$i?>">
						<li onclick="countryChange('RU', $(this));"><i class="glyphicon bfh-flag-RU"></i> Россия</li>
						<li onclick="countryChange('BY', $(this));"><i class="glyphicon bfh-flag-BY"></i> Белорусия</li>
						<li onclick="countryChange('UA', $(this));"><i class="glyphicon bfh-flag-UA"></i> Украина</li>
						<li onclick="countryChange('US', $(this));"><i class="glyphicon bfh-flag-US"></i> США</li>
					</ul>
					</div>
					<div class="col-md-6">
						<input type="text" name="widget_phone_manager_<?=$i?>" class = 'form-control widget_phone' style="display: inline-block">
					</div>
				</div>
			<?}?>
		</div>
		<br>
		<input type="hidden" name="count_phones" value="<?=$count_phones?>">
		<div class="input-group">
			<button class="phone_more btn">Добавить еще один номер телефона</button>
		</div>
	</div>
	<div class="bordered">
		<div class="form-group">
			<label>Настройки рабочего времени</label><br>
			<div class="form-group">
				<div style="margin: 10px 0;">
					<div style="display: inline-block;">
						<?echo $form->field($model, 'widget_work_time_on')->widget(SwitchInput::classname(), [
							'options'=>[
								'onchange'=>'openWorkTime();',
							]
						])->label(false);?>
					</div>
					<div style="display: inline-block">
						<span style="margin: 0 15px;">если настройка выключена, то установлено время работы офиса с 9.00 до 18.00, перерыв на обед с 13.00 до 14.00 7 дней в неделю.</span></div>
				</div>
			</div>
			<div id="openWorkTime" class="work-time-body" <?= ($model->widget_work_time_on)? 'style="display: block;"':'style="display: none;"'?>>
				<div class="line-time">
					<label>Часовой пояс(GMT):</label>
					<select class="form-control" name="widget_GMT">
						<option value="-12">-12</option>
						<option value="-11">-11</option>
						<option value="-10">-10</option>
						<option value="-9">-9</option>
						<option value="-8">-8</option>
						<option value="-7">-7</option>
						<option value="-6">-6</option>
						<option value="-5">-5</option>
						<option value="-4:30">-4:30</option>
						<option value="-4">-4</option>
						<option value="-3:30">-3:30</option>
						<option value="-3">-3</option>
						<option value="-2">-2</option>
						<option value="-1">-1</option>
						<option value="0">+0</option>
						<option value="1">+1</option>
						<option value="2">+2</option>
						<option value="3" selected="selected">+3</option>
						<option value="3:30">+3:30</option>
						<option value="4">+4</option>
						<option value="4:30">+4:30</option>
						<option value="5">+5</option>
						<option value="5:30">+5:30</option>
						<option value="5:45">+5:45</option>
						<option value="6">+6</option>
						<option value="6:30">+6:30</option>
						<option value="7">+7</option>
						<option value="8">+8</option>
						<option value="8:30">+8:30</option>
						<option value="8:45">+8:45</option>
						<option value="9">+9</option>
						<option value="9:30">+9:30</option>
						<option value="10">+10</option>
						<option value="10:30">+10:30</option>
						<option value="11">+11</option>
						<option value="11:30">+11:30</option>
						<option value="12">+12</option>
						<option value="12:45">+12:45</option>
						<option value="13">+13</option>
						<option value="13:45">+13:45</option>
						<option value="14">+14</option>
					</select>
				</div>
				<br>
				<br>
				<?php
				$work_time = json_decode($model->widget_work_time);
				?>
				<table class="table table-striped">
					<tr>
						<th>День недели:</th>
						<th>Начало рабочего дня:</th>
						<th>Конец рабочего дня:</th>
						<th>Обед:</th>
					</tr>
					<tr>
						<td>Понедельник</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-start-time-monday',
								'value' => ''/*$work_time->monday->start*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '09:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-end-time-monday',
								'value' => ''/*$work_time->monday->end*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '18:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-lunch-time-monday',
								'value' => ''/*$work_time->monday->lunch*/,
								'mask' => '99:99 - 99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '13:00 - 14:00'
								]
							]);?>
						</td>
					</tr>
					<tr>
						<td>Вторник</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-start-time-tuesday',
								'value' => ''/*$work_time->tuesday->start*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '09:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-end-time-tuesday',
								'value' => ''/*$work_time->tuesday->end*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '18:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-lunch-time-tuesday',
								'value' => ''/*$work_time->tuesday->lunch*/,
								'mask' => '99:99 - 99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '13:00 - 14:00'
								]
							]);?>
						</td>
					</tr>
					<tr>
						<td>Среда</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-start-time-wednesday',
								'value' => ''/*$work_time->wednesday->start*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '09:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-end-time-wednesday',
								'value' => ''/*$work_time->wednesday->end*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '18:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-lunch-time-wednesday',
								'value' => ''/*$work_time->wednesday->lunch*/,
								'mask' => '99:99 - 99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '13:00 - 14:00'
								]
							]);?>
						</td>
					</tr>
					<tr>
						<td>Четверг</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-start-time-thursday',
								'value' => ''/*$work_time->thursday->start*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '09:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-end-time-thursday',
								'value' => ''/*$work_time->thursday->end*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '18:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-lunch-time-thursday',
								'value' => ''/*$work_time->thursday->lunch*/,
								'mask' => '99:99 - 99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '13:00 - 14:00'
								]
							]);?>
						</td>
					</tr>
					<tr>
						<td>Пятница</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-start-time-friday',
								'value' => ''/*$work_time->friday->start*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '09:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-end-time-friday',
								'value' => ''/*$work_time->friday->end*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '18:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-lunch-time-friday',
								'value' => ''/*$work_time->friday->lunch*/,
								'mask' => '99:99 - 99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '13:00 - 14:00'
								]
							]);?>
						</td>
					</tr>
					<tr>
						<td>Суббота</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-start-time-saturday',
								'value' => ''/*$work_time->saturday->start*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '09:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-end-time-saturday',
								'value' => ''/*$work_time->saturday->end*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '18:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-lunch-time-saturday',
								'value' => ''/*$work_time->saturday->lunch*/,
								'mask' => '99:99 - 99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '13:00 - 14:00'
								]
							]);?>
						</td>
					</tr>
					<tr>
						<td>Воскресенье</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-start-time-sunday',
								'value' => ''/*$work_time->sunday->start*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '09:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-end-time-sunday',
								'value' => ''/*$work_time->sunday->end*/,
								'mask' => '99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '18:00'
								]
							]);?>
						</td>
						<td>
							<?=MaskedInput::widget([
								'name' => 'work-lunch-time-sunday',
								'value' => ''/*$work_time->sunday->lunch*/,
								'mask' => '99:99 - 99:99',
								'options' => [
									'class' => 'form-control',
									'data-required' => true,
									'placeholder' => '13:00 - 14:00'
								]
							]);?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="bordered">
		<div class="form-group">
			<label>Настройки социальных сетей</label><br>
			<div style="display: inline-block">
                    <span style="margin: 0 0px;">
                        После осуществления звонка и оценки качества обсуживания Вашими менджерами, мы предложим соц сети клиенту что бы подружится с Вашим проектом.
                    </span>
			</div><br/>
			<?php
			$social = json_decode($model->social);
			?>
			<table class="table table-striped">
				<tr>
					<td class="col-md-1">
						<img class="img-responsive" src="/images/vkontakte.png"
							 style="max-height: 35px; max-width: 35px"
							 alt="Вконтакте">
					</td>
					<td>
						<input type="text" name = 'social-vk' value = ""
							   class = 'form-control col-md-1' data-required = true
							   placeholder = 'адресс без http:// или https://'>
					</td>
				</tr>
				<tr>
					<td class="col-md-1">
						<img class="img-responsive" src="/images/odnoklassniki.png"
							 style="max-height: 35px; max-width: 35px"
							 alt="Однокласники">
					</td>
					<td>
						<input type="text" name = 'social-ok' value = ""
							   class = 'form-control col-md-1' data-required = true
							   placeholder = 'адресс без http:// или https://'>
					</td>

				</tr>
				<tr>
					<td class="col-md-1">
						<img class="img-responsive" src="/images/facebook.png"
							 style="max-height: 35px; max-width: 35px"
							 alt="FaceBook">
					</td>
					<td>
						<input type="text" name = 'social-facebook' value = ""
							   class = 'form-control col-md-1' data-required = true
							   placeholder = 'адресс без http:// или https://'>
					</td>

				</tr>
				<tr >
					<td class="col-md-1">
						<img class="img-responsive" src="/images/twitter_new.png"
							 style="max-height: 35px; max-width: 35px"
							 alt="Twitter">
					</td>
					<td>
						<input type="text" name = 'social-twitter' value = ""
							   class = 'form-control col-md-1' data-required = true
							   placeholder = 'адресс без http:// или https://'>
					</td>

				</tr>
				<tr >
					<td class="col-md-1">
						<img class="img-responsive" src="/images/instagram-new.png"
							 style="max-height: 35px; max-width: 35px"
							 alt="Instagram">
					</td>
					<td>
						<input type="text" name = 'social-insta' value = ""
							   class = 'form-control col-md-1' data-required = true
							   placeholder = 'адресс без http:// или https://'>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="line-time">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-block btn-success btn-lg']) ?>
	</div>
	<div class="line-time">
		<?= Html::button('Отменить', ['class' => 'btn btn-block btn-danger btn-lg']) ?>
	</div>

	<?php ActiveForm::end(); ?>
	<script type="text/javascript">

		$('.btn-danger').click(function(){
			window.location.href='widgets';
		});
	</script>

	<style>
		.colorpicker-element .input-group-addon i {border: 1px solid #d2d6de;}
		.utm-closed {position: relative; top: -2%; left: 98%; border: 1px solid rgba(0, 0, 0, .1); width: 30px; border-radius: 15px; text-align: center; box-shadow: 0 0 0 3px rgba(0, 0, 0, .4); font-weight: 900; height: 30px; color: rgba(0, 0, 0, .63); box-sizing: border-box; padding: 2px; z-index: 10; -webkit-transition: all .3s ease-out; transition: all .3s ease-out; cursor: pointer; background: #f1f1f1 url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABBElEQVQ4T5WT63KCMBSEd+FJK2K9VPxfwXEG+wDiCF56f7NOn0OOkyg2YkIxf2G/bM7u4egp/ik9zIts8YE7znASh6WUMw6i+IHAnsLeepW+t2Fo8aHMPd8PqASjcdIRyq4NRIkhKEB28mX6rQHqDCdxAMEWxGO+XLzZnFRigQRF9vKl/rkA/oPYxDcA/Zwo6QpkQ7C/ztLXM/hkW9jNV+mn6e7KQfXBhAiFLrHVgTGT060ABAhdMVsdXNlWg2qI2Ar4GxhCT8imiG8Al5yNgTX1pB6jc9ouiFkkLTZLUi+TDaIBrpLY2liH0FwM1e02y1RBVLzsR8+/Hv1pW3F1gdpiAMkRptjH3QzyD+8AAAAASUVORK5CYII='); background-repeat: no-repeat; background-position: center center;}
		.utp-exampl {max-width: 800px; max-height:800px; background-repeat: no-repeat;}
		.utp-exampl .utp-form {position: relative; top: 0; left: 0; width: 200px; height: 70px; z-index: 9; cursor: move;}
		.utp-exampl .utp-form .line input,.utp-exampl .utp-form .line button {box-shadow:0 0 0 3px rgba(0, 0, 0, .2); border-radius: 15px; width: 100%; height: 30px; margin-bottom: 10px; border: 1px solid #CACACA; position:relative; z-index: -1; padding: 5px 0 5px 10px; background: #f5f5f5;}
		.utp-exampl .utp-form .line button {margin: 0;}
		span.phone   {font-weight: 400; font-size: 14px;}
		.light-label {vertical-align: middle; margin-right: 10px;}
		.bootstrap-switch-label {background: #f9f9f9 !important;}
		.clear {clear: both;}
		.line-time {width:30%; margin-left: 2%; display: inline-block;}
		.bordered {color: #333333; font-family: "Open Sans", sans-serif; border: 1px solid #e1e1e1; padding: 1%; background:#fff; margin:1%;}
		.bordered, .bordered * {-webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;}
		.color_theme_list__ul{list-style: none;}
		.color_theme_list__ul__item{width: 50px; height: 50px; display: inline-block; vertical-align: top; margin: 10px; line-height: 28px; text-align: center; border-radius: 30px; cursor: pointer;}
		.color_theme_list__ul__item.active{border: 2px rgb(33, 204, 252) solid;}
		.widget-position, .widget-position-mob {width: 100%; margin-top: 45px;}
		.widget-top-position, .widget-top-position-mob {background-color: #f7f7f7; background-image: -moz-linear-gradient(top, #f0f0f0, #f9f9f9); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f0f0f0), to(#f9f9f9)); background-image: -webkit-linear-gradient(top, #f0f0f0, #f9f9f9); background-image: -o-linear-gradient(top, #f0f0f0, #f9f9f9); background-image: linear-gradient(to bottom, #f0f0f0, #f9f9f9); background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff0f0f0', endColorstr='#fff9f9f9', GradientType=0); -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; height: 400px; width: 10px; float:left;margin: 0 10px 0 0;}
		.widget-top-position-mob {height: 400px;margin: 0 10px 0 0;}
		.widget-left-position, .widget-left-position-mob {background-color: #f7f7f7; background-image: -moz-linear-gradient(top, #f0f0f0, #f9f9f9); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f0f0f0), to(#f9f9f9)); background-image: -webkit-linear-gradient(top, #f0f0f0, #f9f9f9); background-image: -o-linear-gradient(top, #f0f0f0, #f9f9f9); background-image: linear-gradient(to bottom, #f0f0f0, #f9f9f9); background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff0f0f0', endColorstr='#fff9f9f9', GradientType=0); -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; height: 10px;float: left;}
		.widget-left-position {width: 600px;margin: 17px 0 0 24px;}
		.widget-left-position-mob {width: 232px;margin: 17px 0 0 24px;}
		.widget-body-position, .widget-body-position-mob {width: 94%; width: calc(100% - 15px); height: 225px; margin: 0 0 0 5px; float: left; border: 1px #dedede solid;}
		.widget-top-position .button, .widget-top-position-mob .button {top: 88%;}
		.widget-left-position .button, .widget-left-position-mob .button {margin: -5px 0 0 0; left:94%;}
		.ui-state-default {
			background: #444!important;
			height: 21px!important;
			width: 21px!important;
			border-radius: 100%;
			outline: none;
			cursor: pointer!important;
			margin: -3px!important;
		}
	</style>

	<!-- /.row -->
	<!-- Main row -->

	<!-- /.row (main row) -->

</section>

<script>
	//Настройка виджета Десктоп

	$(".widget-top-position").slider({
		orientation: "vertical",
		range: "min",
		min: 0,
		max: 100,
		value: 10,
		slide: function( event, ui ) {
			$(".robax-widget-open-button").css('top', (100 - ui.value) + '%');
			$("[name='witget-button-top']").val('top: ' + (100 - ui.value) + '%;');
		}
	});
	$(".widget-left-position").slider({
		range: "min",
		min: 0,
		max: 100,
		value: 10,
		slide: function( event, ui ) {
			$(".robax-widget-open-button").css('left', (ui.value) + '%');
			$("[name='witget-button-left']").val('left: ' + (ui.value) + '%;');
		}
	});
	//Настройка виджета Мобайл

	$(".widget-top-position-mob").slider({
		orientation: "vertical",
		range: "min",
		min: 0,
		max: 100,
		value: 10,
		slide: function( event, ui ) {
			$(".robax-widget-open-button-mob").css('top', (100 - ui.value) + '%');
			$("[name='witget-button-top-mob']").val('top: ' + (100 - ui.value) + '%;');
		}
	});
	$(".widget-left-position-mob").slider({
		range: "min",
		min: 0,
		max: 100,
		value: 10,
		slide: function( event, ui ) {
			$(".robax-widget-open-button-mob").css('left', (ui.value) + '%');
			$("[name='witget-button-left-mob']").val('left: ' + (ui.value) + '%;');
		}
	});
	//Добавление телефона (чёрный список)
	var k = <?=$count_black_list?>;
	$('.blacklist_more').click(function(e){
		k++;
		e.preventDefault();
		var BL_input = '<span class="phone">Телефон №'+k+'</span><div class="input-group"><input type="text" style="padding-left: 45px;" class="form-control widget_phone" name="black_list_number_'+k+'" placeholder="+7(___)___-__-__" data-required="false">' +
			'<button class="flag-select dropdown-toggle" type="button" id="dropdownMenu_'+k+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon bfh-flag-RU"></i><span class="caret"></span></button>' +
			'<ul class="dropdown-menu" aria-labelledby="dropdownMenu_'+k+'">' +
			'<li onclick="countryChange(\'RU\', $(this));"><i class="glyphicon bfh-flag-RU"></i> Россия</li>' +
			'<li onclick="countryChange(\'BY\', $(this));"><i class="glyphicon bfh-flag-BY"></i> Белорусия</li>' +
			'<li onclick="countryChange(\'UA\', $(this));"><i class="glyphicon bfh-flag-UA"></i> Украина</li>' +
			'<li onclick="countryChange(\'US\', $(this));"><i class="glyphicon bfh-flag-US"></i> США</li>' +
			'</ul>'+
			'</div>';
		$('#black_list_block').append(BL_input);
		$("input[name='black_list_number_"+k+"']").inputmask("+7(999)999-99-99");
		$('input[name="count_black_list"]').val(k);
	});
	//Добавление емэйла (настройка уведомлений)
	var i = <?=$count_mails?>;
	$('.email_more').click(function(e){
		i++;
		e.preventDefault();
		var email_input = '<span class="phone">Ваша эл-почта</span><div class="input-group"> <div class="input-group-addon"><b>@</b></div> <input type="text" class="form-control" name="widget_user_email_'+i+'" placeholder="Email" data-required="true"> </div>';
		$('#emails_block').append(email_input);
		$('input[name="count_emails"]').val(i);
	});
	//Добавление телефона (определяется при звонке клиенту)
	var j = <?=$count_phones?>;
	$('.phone_more').click(function(e){
		j++;
		e.preventDefault();
		var phone_input = '<span class="phone">Телефон №'+j+'</span><div class="input-group"><div class="col-md-6"><input type="text" style="padding-left: 45px;display: inline-block;" class="form-control widget_phone" name="widget_phone_number_'+j+'" placeholder="+7(___)___-__-__" data-required="false">' +
			'<button style="margin-left: 20px;" class="flag-select dropdown-toggle" type="button" id="dropdown2Menu_'+j+'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon bfh-flag-RU"></i><span class="caret"></span></button>' +
			'<ul class="dropdown-menu" aria-labelledby="dropdown2Menu_'+j+'">' +
			'<li onclick="countryChange(\'RU\', $(this));"><i class="glyphicon bfh-flag-RU"></i> Россия</li>' +
			'<li onclick="countryChange(\'BY\', $(this));"><i class="glyphicon bfh-flag-BY"></i> Белорусия</li>' +
			'<li onclick="countryChange(\'UA\', $(this));"><i class="glyphicon bfh-flag-UA"></i> Украина</li>' +
			'<li onclick="countryChange(\'US\', $(this));"><i class="glyphicon bfh-flag-US"></i> США</li>' +
			'</ul>'+
			'</div>'+
				'<div class="col-md-6">'+
				'<input type="text" name="widget_phone_manager_'+j+'" class = "form-control widget_phone" style="display: inline-block;">'+
			'</div>'+
			'</div>';
		$('#phones_block').append(phone_input);
		$("input[name='widget_phone_number_"+j+"']").inputmask("+7(999)999-99-99");
		$('input[name="count_phones"]').val(j);
		$('input[name="widget_phone_manager_'+j+'"]');
	});
	//Добавит страницу
	var l = <?=$count_site_pages?>;
	$('.sitepage_more').click(function(e){
		l++;
		e.preventDefault();
		var page_input = '<span class="phone">Ссылка на страницу</span><div class="input-group"><div class="input-group-addon"><i class="fa fa-link"></i></div><input type="text" class="form-control" name="site_page_'+l+'" placeholder="URL"> </div><select class="form-control" name="select_site_page_'+l+'"><option value="0">0 баллов</option> <option value="1">1 балл</option> <option value="2">2 балла</option> <option value="3">3 балла</option> <option value="4">4 балла</option> <option value="5">5 баллов</option> <option value="6">6 баллов</option> <option value="7">7 баллов</option> <option value="8">8 баллов</option> <option value="9">9 баллов</option> <option value="10">10 баллов</option> </select><br>';
		$('#pages_block').append(page_input);
		$('input[name="count_pages"]').val(l);
	});
	//Уникальное торговое предложение
	/*$(".utm-button-color").colorpicker().on('changeColor',function(){
	 $('.utp-form .line button').css('background',$(this).val());
	 });
	 $('#url_utp_img').change(function(){
	 $('.utp-img-exampl').attr("src",this.value);
	 $('.utp-img-exampl').load(function(){
	 $('.utp-exampl').css({
	 'background': 'url('+this.src+')',
	 'width': $('.utp-img-exampl').width()+'px',
	 'height': $('.utp-img-exampl').height()+'px'
	 });
	 });
	 });
	 $('.utp-form').draggable({
	 stop: function() {
	 $("[name='widget-utp-form-top']").val('top: '+$(this).css('top')+';');
	 $("[name='widget-utp-form-left']").val('left: '+$(this).css('left')+';');
	 },
	 containment: '.utp-exampl',
	 scroll: false
	 });*/
	//
	$(".my-colorpicker").colorpicker();
	$('.color_theme_list__ul__item').eq(0).click(function(){
		$(this).attr("class","color_theme_list__ul__item active");
		$('.color_theme_list__ul__item').eq(1).attr("class","color_theme_list__ul__item");
		$("[name='widget_theme_color']").val(0);
	});
	$('.color_theme_list__ul__item').eq(1).click(function(){
		$(this).attr("class","color_theme_list__ul__item active");
		$('.color_theme_list__ul__item').eq(0).attr("class","color_theme_list__ul__item");
		$("[name='widget_theme_color']").val(1);
	});
	//Функции
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

	function openMarks() {
		if ($('#openMarks').css('display') == 'none') {
			$('#openMarks').show();
		} else {
			$('#openMarks').hide();
		}
	}
	function openMessages() {
		if ($('#openMessages').css('display') == 'none') {
			$('#openMessages').show();
		} else {
			$('#openMessages').hide();
		}
	}
	function openWorkTime() {
		if ($('#openWorkTime').css('display') == 'none') {
			$('#openWorkTime').show();
		} else {
			$('#openWorkTime').hide();
		}
	}

	function openUtp() {
		if ($('#openUtp').css('display') == 'none') {
			$('#openUtp').show();
		} else {
			$('#openUtp').hide();
		}
	}
	function openBlock(id) {
		if ($('#openBlock-'+id).css('display') == 'none' && $('.bootstrap-switch-id-w'+id).hasClass('bootstrap-switch-on')) {
			$('#w'+id).val(1);
			$('#openBlock-'+id).show();
		} else {
			$('#w'+id).val(0);
			$('#openBlock-'+id).hide();
		}
	}
	function siteChange(url) {
		address = ['http://', 'https://'];
		new_url = url.replace(address, '');
		if (url.length) {
			$('#screenDesktop').attr('src', 'http://mini.s-shot.ru/1280x800/JPEG/1280/Z100/?'+new_url);
			$('#screenMobile').attr('src', 'http://mini.s-shot.ru/360x640/JPEG/360/Z100/?'+new_url);
			$.ajax({
				url: '/profile/savesiteimage',
				method: 'POST',
				data: {
					url_desktop: 'http://mini.s-shot.ru/1280x800/JPEG/1280/Z100/?'+new_url,
					url_mobile: 'http://mini.s-shot.ru/360x640/JPEG/360/Z100/?'+new_url,
					site: url
				}
			});
		}
	}
</script>