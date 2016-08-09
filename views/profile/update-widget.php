<?php
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\User;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
$this->registerJsFile('@web/plugins/bootstrap/js/bootstrap.min.js');
$path = '/files/images/desktop/';
$path2 = '/files/images/mobile/';
$this->title = 'Изменить виджет';
?>
  <section class="content-header">
    <h1>
      Редактирование
      <small>виджета №<?=$model->widget_id?></small>
    </h1>
    <!--<ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>-->
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
          <script type="text/javascript">
            $("[name='widget_sound']").val(<?=$model->widget_sound?>);
          </script>
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
        <script type="text/javascript">
          $("[name='widget_theme_color']").val(<?=$model->widget_theme_color?>);
          var theme_id=<?=$model->widget_theme_color?>;
          if(theme_id==0)	$(".color_theme_list__ul__item").eq(1).attr("class","color_theme_list__ul__item active");
          else $(".color_theme_list__ul__item").eq(0).attr("class","color_theme_list__ul__item active");
        </script>
        <label>Цвет кнопки</label><br>
        <div class="input-group my-colorpicker colorpicker-element" style="width: 35%;">
          <input type="text" name="widget_button_color" class="form-control"  placeholder="Цвет кнопки" value="<?=$model->widget_button_color?>">
          <div class="input-group-addon">
            <i></i>
          </div>
        </div>
        <script type="text/javascript">
          $("[name='widget_button_color']").change(function(){
            $("#open-button").style.background = '#FFF';
          });
        </script>
      </div>
      <div class="form-group col-sm-6 bordered" style="width: 65%;">
        <label>Расположение виджета</label><br>
        <div class="widget-position">
          <div class="widget-top-position">
          </div>
          <div class="widget-body-position" style="width: 600px;height: 400px;">
            <div class="robax-widget-open-button" id="open-button" style="z-index: 100;background: <?=$model->widget_button_color?>; border-radius: 100%; position: relative; <?=$model->widget_position?> width: 38px; height: 38px;">
              <?=Html::img('@web'.'/widget-front/img/phone-icon.png',['class' => "phone", 'style' => 'margin: 9px; width: 21px; height: 21px;']); ?>
            </div>
            <img style="width: 600px;height: 400px;position: relative;top: -40px;" id="screenDesktop" src="<?=$path.$model->widget_id.'-'.$model->widget_site_url.'.jpg'?>"/>
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
            <div class="robax-widget-open-button-mob" id="open-button-mob" style="z-index: 100;background: <?=$model->widget_button_color?>; border-radius: 100%; position: relative; <?=$model->widget_position_mobile?> width: 34px; height: 34px;">
              <?=Html::img('@web'.'/widget-front/img/phone-icon.png',['class' => "phone", 'style' => 'margin: 9px; width: 18px; height: 18px;']); ?>
            </div>
            <img style="width: 225px;height: 400px;position: relative;top: -35px;" id="screenMobile" src="<?=$path2.$model->widget_id.'-'.$model->widget_site_url.'.jpg'?>"/>
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
        <div style="margin: 10px 0;"><input class="check-box-button open-marks" name="hand_turn_on"
                                            type="checkbox" <?=($model->hand_turn_on)? "checked":"";?>><span style="margin: 0 15px;">Настроить вручную</span></div>
        <div class="marks-body" <?= ($model->hand_turn_on)? 'style="display: block;':'style="display: none;'?>">
          <?php
          $items = [
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
          ];
          ?>
          <table>
            <tr>
              <td style="padding-right:10px">Переход на другую страницу</td>
              <td style="padding-right:15px"><?=Html::dropDownList('other_page',$marks->other_page,$items);?></td>
              <td>Посещение более 3х страниц сайта</td>
              <td><?=Html::dropDownList('sitepage3_activity',$items[$marks->sitepage3_activity],$items);?></td>
            </tr>
            <tr>
              <td>Скролл вниз(за 100% страницы)</td>
              <td><?=Html::dropDownList('scroll_down',$marks->scroll_down,$items);?></td>
              <td>Дольше среднего времени на сайте</td>
              <td><?=Html::dropDownList('more_avgtime',$marks->more_avgtime,$items);?></td>
            </tr>
            <tr>
              <td>Активность на сайте более 40 сек.</td>
              <td><?=Html::dropDownList('active_more40',$marks->active_more40,$items);?></td>
              <td>За каждые 30 сек., после 1 мин.</td>
              <td><?=Html::dropDownList('moretime_after1min',$marks->moretime_after1min,$items);?></td>
            </tr>
            <tr>
              <td>Интенсивность движения мышки</td>
              <td><?=Html::dropDownList('mouse_intencivity',$marks->mouse_intencivity,$items);?></td>
              <td>Взаимодействие с формами</td>
              <td><?=Html::dropDownList('form_activity',$marks->form_activity,$items);?></td>
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
          <script type=text/javascript>
            var l = <?=$count_site_pages?>;
            $('.sitepage_more').click(function(e){
              e.preventDefault();
              l++;
              var page_input = '<span class="phone">Ссылка на страницу</span><div class="input-group"><div class="input-group-addon"><i class="fa fa-link"></i></div><input type="text" class="form-control" name="site_page_'+l+'" placeholder="URL"> </div><select class="form-control" name="select_site_page_'+l+'"><option value="0">0 баллов</option> <option value="1">1 балл</option> <option value="2">2 балла</option> <option value="3">3 балла</option> <option value="4">4 балла</option> <option value="5">5 баллов</option> <option value="6">6 баллов</option> <option value="7">7 баллов</option> <option value="8">8 баллов</option> <option value="9">9 баллов</option> <option value="10">10 баллов</option> </select><br>';
              $('#pages_block').append(page_input);
              $('input[name="count_pages"]').val(l);
            });
          </script>
          <br>
        </div>
      </div>
      <div class="clear"></div>
      <div class="bordered">
        <label>УТП  </label><br>
        <div style="margin: 10px 0;"><input class="check-box-button open-utm" type="checkbox"
                                            <?=($model->utp_turn_on)? "checked":"";?> name="utp_turn_on"><span style="margin: 0 15px;">уникальное торговое предложение, выводится при попытки уйти с сайта</span></div>
        <div class="utp-body" <?= ($model->utp_turn_on)? 'style="display: block;':'style="display: none;'?>">
          <div class="callout callout-info"><p>Максимальный размер изображения: 800 x 800</p></div>
          <input maxlength="500" id="url_utp_img" name="utp-img-url" type="text" class="form-control" placeholder="URL изображения" value="<?$model->utp_img_url?>">
          <br />
          <label>Цвет кнопки</label>
          <div class="input-group  colorpicker-element" style="width: 400px;">
            <input type="text" name="utm-button-color" class="form-control utm-button-color my-colorpicker"  placeholder="Цвет кнопки" value="<?$model->utm_button_color?>">
            <!--<div class="input-group-addon">
              <i></i>
            </div>-->
          </div>
          <br>
          <div class="utp-exampl">
            <div class="utm-closed"></div>
            <div class="utp-form" style="<?$model->widget_utp_form_position?>">
              <div class="line"><input type="text" placeholder="Введите ваш телефон" /></div>
              <div class="line"><button style="background: <?$model->utm_button_color?>;">Отправить</button></div>
            </div>
          </div>
          <img class="utp-img-exampl" style="visibility: hidden;"/>
          <input name="widget-utp-form-left" value="top:0%;" type="hidden">
          <input name="widget-utp-form-top" value="left:0%;" type="hidden">
        </div>
      </div>
      <div class="bordered">
        <label>Черный список </label><small>(укажите номера, на которые виджет не будет звонить)</small>
        <br>
        <div id="black_list_block">
          <?php
          $blackList = explode(';', $model->black_list);
          $num = count($blackList)-1;
          unset($blackList[$num]);
          $count_black_list = count($blackList);
          for($i=1; $i<=$count_black_list; $i++)
          {
            echo '<span class="phone">Телефон №'.$i.'</span>
                <div class="input-group">
                <div class="input-group-addon">
                <i class="fa fa-phone"></i>
                </div>
                <input type="text" class="form-control widget_phone" name="black_list_number_'.$i.'" placeholder="+7(___)___-__-__" data-required="true" value="'.$blackList[$i-1].'">
                </div>';
          }
          ?>
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
              <span>Если на сайте подключено <b>Google Analytics</b></span></div>
            </div>
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
            {
              echo '<span class="phone">Ваша эл-почта</span>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <b>@</b>
                        </div>
                        <input type="text" class="form-control" name="widget_user_email_'.$i.'" placeholder="Email" data-required="true" value="'.$mails[$i-1].'">
                    </div>';
            }
          ?>
        </div>
        <br>
        <input type="hidden" name="count_emails" value="<?=$count_mails?>">
        <div class="input-group">
          <button class="email_more btn">Добавить еще один email</button>
        </div>
        <br>
        <!--<div class="callout callout-info"><p>Телефон №1 </p></div>-->
        <div id="phones_block">
          <?php
          $phones = explode(';', $model->widget_phone_numbers);
          $num = count($phones)-1;
          unset($phones[$num]);
          $count_phones = count($phones);
          for($i=1; $i<=$count_phones; $i++)
          {
            echo '<span class="phone">Телефон №'.$i.'</span>
                  <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <input type="text" class="form-control widget_phone" name="widget_phone_number_'.$i.'" placeholder="+7(___)___-__-__" data-required="true" value="'.$phones[$i-1].'">
                  </div>';
          }
          ?>
        </div>
        <br>
        <input type="hidden" name="count_phones" value="<?=$count_phones?>">
        <div class="input-group">
          <button class="phone_more btn">Добавить еще один номер телефона</button>
        </div>
      </div>
      <div class="bordered">
        <div class="form-group">
          <label>Настройки времени</label><br>
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
//          print_r($work_time);
//          die();
          ?>
          <table class="table table-striped">
            <tr>
              <th>День недели:</th>
              <th>Начало рабочего дня:</th>
              <th>Конец рабочего дня:</th>
            </tr>
            <tr>
              <td>Понедельник</td>
              <td><input class="form-control" name="work-start-time-monday" type="text" placeholder="09:00" value="<?=$work_time->monday->start?>"></td>
              <td><input class="form-control" name="work-end-time-monday" type="text" placeholder="18:00" value="<?=$work_time->monday->end?>"></td>
            </tr>
            <tr>
              <td>Вторник</td>
              <td><input class="form-control" name="work-start-time-tuesday" type="text" placeholder="09:00" value="<?=$work_time->tuesday->start?>"></td>
              <td><input class="form-control" name="work-end-time-tuesday" type="text" placeholder="18:00" value="<?=$work_time->tuesday->end?>"></td>
            </tr>
            <tr>
              <td>Среда</td>
              <td><input class="form-control" name="work-start-time-wednesday" type="text" placeholder="09:00" value="<?=$work_time->wednesday->start?>"></td>
              <td><input class="form-control" name="work-end-time-wednesday" type="text" placeholder="18:00" value="<?=$work_time->wednesday->end?>"></td>
            </tr>
            <tr>
              <td>Четверг</td>
              <td><input class="form-control" name="work-start-time-thursday" type="text" placeholder="09:00" value="<?=$work_time->thursday->start?>"></td>
              <td><input class="form-control" name="work-end-time-thursday" type="text" placeholder="18:00" value="<?=$work_time->thursday->end?>"></td>
            </tr>
            <tr>
              <td>Пятница</td>
              <td><input class="form-control" name="work-start-time-friday" type="text" placeholder="09:00" value="<?=$work_time->friday->start?>"></td>
              <td><input class="form-control" name="work-end-time-friday" type="text" placeholder="18:00" value="<?=$work_time->friday->end?>"></td>
            </tr>
            <tr>
              <td>Суббота</td>
              <td><input class="form-control" name="work-start-time-saturday" type="text" placeholder="09:00" value="<?=$work_time->saturday->start?>"></td>
              <td><input class="form-control" name="work-end-time-saturday" type="text" placeholder="18:00" value="<?=$work_time->saturday->end?>"></td>
            </tr>
            <tr>
              <td>Воскресенье</td>
              <td><input class="form-control" name="work-start-time-sunday" type="text" placeholder="09:00" value="<?=$work_time->sunday->start?>"></td>
              <td><input class="form-control" name="work-end-time-sunday" type="text" placeholder="18:00" value="<?=$work_time->sunday->end?>"></td>
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
      $(".check-box-button").bootstrapSwitch();
      //------
      $(".utm-button-color").colorpicker().on('changeColor',function(){
        $('.utp-form .line button').css('background',$(this).val());
      });
      $('.open-utm').on('switchChange.bootstrapSwitch', function(event, state) {
        var css=$('.utp-body').css('display');
        if(css==''||css=='block')$('.utp-body').hide();
        else $('.utp-body').show();
        console.log(css);
      });
      $('.open-marks').on('switchChange.bootstrapSwitch', function(event, state) {
        var css=$('.marks-body').css('display');
        if(css==''||css=='block')$('.marks-body').hide();
        else $('.marks-body').show();
        console.log(css);
      });
      $('#url_utp_img').change(function(){
        $('.utp-img-exampl').attr("src",this.value);
        $('.utp-img-exampl').load(function(){
          $('.utp-exampl').css({"background":'url('+this.src+')','width':$('.utp-img-exampl').width()+'px','height':$('.utp-img-exampl').height()+'px'});
          $('.utp-img-exampl').hide();
        });
      });
      $('.utp-exampl .utp-form').mousedown(function(){
        var left=$(".utp-exampl").offset().left,top=$(".utp-exampl").offset().top,width=$(".utp-exampl").width(),height=$(".utp-exampl").height(),WidthPercent=width/100,HeightPercent=height/100;
        var newTop=0,newLeft=0;
        $(this).bind('mousemove',function(e){
          var position=e.pageX-50;
          if(position>=left&&position<=left+width-50){
            newLeft=(position-left)/WidthPercent;
          }
          console.log($(this).height());
          position=e.pageY-50;
          if(position>=top&&position<=top+height-50){
            newTop=(position-top)/HeightPercent;
          }
          $(this).css('left',Math.ceil(newTop)+'%');
          $(".utp-exampl .utp-form").eq(0).css({'left':Math.ceil(newLeft)+'%','top':Math.ceil(newTop)+'%'});
          $("[name='widget-utp-form-left']").val('left:'+Math.ceil(newLeft)+'%;');
          $("[name='widget-utp-form-top']").val('top:'+Math.ceil(newTop)+'%;');
        });
      });
      //---------
      $('.utp-exampl .utp-form').mouseup(function(){
        $(this).unbind('mousemove');
      });
      $(".check-box-button").bootstrapSwitch();
      // Mask`s
      helper.setMask($("[name='widget_phone_number_1']")[0],'+7(999)999-99-99');
      helper.setMask($("[name='work-start-time-monday']")[0],'99:99');
      helper.setMask($("[name='work-end-time-monday']")[0],'99:99');
      helper.setMask($("[name='work-start-time-tuesday']")[0],'99:99');
      helper.setMask($("[name='work-end-time-tuesday']")[0],'99:99');
      helper.setMask($("[name='work-start-time-wednesday']")[0],'99:99');
      helper.setMask($("[name='work-end-time-wednesday']")[0],'99:99');
      helper.setMask($("[name='work-start-time-thursday']")[0],'99:99');
      helper.setMask($("[name='work-end-time-thursday']")[0],'99:99');
      helper.setMask($("[name='work-start-time-friday']")[0],'99:99');
      helper.setMask($("[name='work-end-time-friday']")[0],'99:99');
      helper.setMask($("[name='work-start-time-saturday']")[0],'99:99');
      helper.setMask($("[name='work-end-time-saturday']")[0],'99:99');
      helper.setMask($("[name='work-start-time-sunday']")[0],'99:99');
      helper.setMask($("[name='work-end-time-sunday']")[0],'99:99');
      //---------
      $('.btn-success').click(function(){
        var param={action:'widget-edit',id:<?=$model->widget_id?>};
      //param['widget_name']=$("[name='widget_name']").val();
      param['widget_site_url']=$("[name='widget_site_url']").val();
      param['widget_sound']=$("[name='widget_sound']").val();
      param['widget_theme_color']=$("[name='widget_theme_color']").val();
      param['widget_button_color']=$("[name='widget_button_color']").val();
      param['widget_phone_number_1']=$("[name='widget_phone_number_1']").val();
      param['widget_phone_number_2']=$("[name='widget_phone_number_2']").val();
      param['widget_phone_number_3']=$("[name='widget_phone_number_3']").val();
      param['widget_phone_number_4']=$("[name='widget_phone_number_4']").val();
      param['widget_user_email']=$("[name='widget_user_email']").val();
      param['widget_GMT']=$("[name='widget_GMT']").val();
      param['position']=$("[name='witget-button-top']").val()+$("[name='witget-button-left']").val();
      param['position_mob']=$("[name='witget-button-top-mob']").val()+$("[name='witget-button-left-mob']").val();
      param['widget-utp-form-position']=$("[name='widget-utp-form-top']").val()+$("[name='widget-utp-form-left']").val();
      param['utm-button-color']=$("[name='utm-button-color']").val();
      param['utp-img-url']=$("[name='utp-img-url']").val();
      param['settings']=new Object;
      param['other_page'] = $("[name='other_page']").val();
      param['scroll_down'] = $("[name='scroll_down']").val();
      param['active_more40'] = $("[name='active_more40']").val();
      param['mouse_intencivity'] = $("[name='mouse_intencivity']").val();
      param['sitepage_activity'] = $("[name='sitepage_activity']").val();
      param['sitepage3_activity'] = $("[name='sitepage3_activity']").val();
      param['more_avgtime'] = $("[name='more_avgtime']").val();
      param['moretime_after1min'] = $("[name='moretime_after1min']").val();
      param['form_activity'] = $("[name='form_activity']").val();
      param['client_activity'] = $("[name='client_activity']").val();
      var time_start=$("[name='work-start-time']").val(),time_end=$("[name='work-end-time']").val();
      var test_start_time=Number(time_start.split(':')[0]*60)+Number(time_start.split(':')[1]),test_end_time=Number(time_end.split(':')[0]*60)+Number(time_end.split(':')[1]);
      param['settings']=JSON.stringify(param['settings']);
      param['widget_work_time']='{"work-start-time":"'+$("[name='work-start-time']").val()+'","work-end-time":"'+$("[name='work-end-time']").val()+'"}';
      for(var k in param){
        if(param[k]==undefined&&($("[name='"+k+"']").attr('data-required')==true&&$("[name='"+k+"']").val()=='')){
          $("[name='"+k+"']").parent().addClass('has-error');
          return false;
        }
      }
      if(test_start_time<test_end_time&&test_start_time<1440&&test_end_time<1440) $.post('/route.php',param,function(r){
        console.log(param);
        console.log(JSON.parse(r.replace(/\ufeff/g,'')));
        var o=JSON.parse(r.replace(/\ufeff/g,'')),info={};
        info['msg']=o['msg']; info['title']='Информационное окно';
        var html=helper.replaceAll(document.getElementById('modal').innerHTML,info);
        document.getElementsByTagName('body')[0].innerHTML+=html;
        $('.close,.modal-dialog .btn').click(function(){
          window.location.hash='widgets';
          $('.modal-info').remove();
        });
      });
      else {
        if(test_start_time<test_end_time||test_start_time<1440) $("[name='work-start-time']").parent().addClass('has-error');
        if(test_end_time<1440) $("[name='work-end-time']").parent().addClass('has-error');
        return false;
      }
      });

      $('.btn-danger').click(function(){
        window.location.href='../widgets';
      });

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
    </script>
    <script type="text/javascript">
      var time=<?=$model->widget_work_time?>;
      if(time!=null){
        $("[name='work-start-time']").val(time['work-start-time']);
        $("[name='work-end-time']").val(time['work-end-time']);
      }
      if("<?=$model->utp_img_url?>".length>0) {
        $('.utp-img-exampl').attr("src","<?=$model->utp_img_url?>");
        $('.utp-img-exampl').load(function(){
          $('.utp-exampl').css({"background":'url('+this.src+')','width':$('.utp-img-exampl').width()+'px','height':$('.utp-img-exampl').height()+'px'});
          $('.utp-img-exampl').hide();
        });
        $('.open-utm').data().bootstrapSwitch.toggleState();
      }
      else var settings=new Object();
    </script>
    <style>
      .colorpicker-element .input-group-addon i {border: 1px solid #d2d6de;}
      .utm-closed {position: relative; top: -2%; left: 98%; border: 1px solid rgba(0, 0, 0, .1); width: 30px; border-radius: 15px; text-align: center; box-shadow: 0 0 0 3px rgba(0, 0, 0, .4); font-weight: 900; height: 30px; color: rgba(0, 0, 0, .63); box-sizing: border-box; padding: 2px; z-index: 10; -webkit-transition: all .3s ease-out; transition: all .3s ease-out; cursor: pointer; background: #f1f1f1 url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABBElEQVQ4T5WT63KCMBSEd+FJK2K9VPxfwXEG+wDiCF56f7NOn0OOkyg2YkIxf2G/bM7u4egp/ik9zIts8YE7znASh6WUMw6i+IHAnsLeepW+t2Fo8aHMPd8PqASjcdIRyq4NRIkhKEB28mX6rQHqDCdxAMEWxGO+XLzZnFRigQRF9vKl/rkA/oPYxDcA/Zwo6QpkQ7C/ztLXM/hkW9jNV+mn6e7KQfXBhAiFLrHVgTGT060ABAhdMVsdXNlWg2qI2Ar4GxhCT8imiG8Al5yNgTX1pB6jc9ouiFkkLTZLUi+TDaIBrpLY2liH0FwM1e02y1RBVLzsR8+/Hv1pW3F1gdpiAMkRptjH3QzyD+8AAAAASUVORK5CYII='); background-repeat: no-repeat; background-position: center center;}
      .utp-exampl {max-width: 800px; max-height:800px; background-repeat: no-repeat;}
      .utp-exampl .utp-form {position: relative; top:0%; left:0%; width: 200px; height: 70px; z-index: 9; cursor: move;}
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
<?php
/*echo "<pre>";
$acttype = "other_page";
print_r(WidgetAnalytics::countConv($model->widget_id));
echo "</pre>";*/
?>
<script>
//Настройка виджета Десктоп
$("[name='witget-button-top']").val('top:'+$('.robax-widget-open-button')[0].style.top+';');
$("[name='witget-button-left']").val('left:'+$('.robax-widget-open-button')[0].style.left+';');
$(".widget-top-position").slider({
  orientation: "vertical",
  range: "min",
  min: 0,
  max: 100,
  value: (100 - parseInt($('.robax-widget-open-button')[0].style.top.replace('%', ''))),
  slide: function( event, ui ) {
    $(".robax-widget-open-button").css('top', (100 - ui.value) + '%');
    $("[name='witget-button-top']").val('top: ' + (100 - ui.value) + '%;');
  }
});
$(".widget-left-position").slider({
  range: "min",
  min: 0,
  max: 100,
  value: parseInt($('.robax-widget-open-button')[0].style.left.replace('%', '')),
  slide: function( event, ui ) {
    $(".robax-widget-open-button").css('left', (ui.value) + '%');
    $("[name='witget-button-left']").val('left: ' + (ui.value) + '%;');
  }
});

//Настройка виджета Мобайл
$("[name='witget-button-top-mob']").val('top:'+$('.robax-widget-open-button-mob')[0].style.top+';');
$("[name='witget-button-left-mob']").val('left:'+$('.robax-widget-open-button-mob')[0].style.left+';');
$(".widget-top-position-mob").slider({
  orientation: "vertical",
  range: "min",
  min: 0,
  max: 100,
  value: (100 - parseInt($('.robax-widget-open-button-mob')[0].style.top.replace('%', ''))),
  slide: function( event, ui ) {
    $(".robax-widget-open-button-mob").css('top', (100 - ui.value) + '%');
    $("[name='witget-button-top-mob']").val('top: ' + (100 - ui.value) + '%;');
  }
});
$(".widget-left-position-mob").slider({
  range: "min",
  min: 0,
  max: 100,
  value: parseInt($('.robax-widget-open-button-mob')[0].style.left.replace('%', '')),
  slide: function( event, ui ) {
    $(".robax-widget-open-button-mob").css('left', (ui.value) + '%');
    $("[name='witget-button-left-mob']").val('left: ' + (ui.value) + '%;');
  }
});
//Добавление телефона (чёрный список)
var k = <?=$count_black_list?>;
$('.blacklist_more').click(function(e){
  e.preventDefault();
  k++;
  var BL_input = '<span class="phone">Телефон №'+k+'</span><div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i> </div> <input type="text" class="form-control widget_phone" name="black_list_number_'+k+'" placeholder="+7(___)___-__-__" data-required="false"></div>';
  $('#black_list_block').append(BL_input);
  $("input[name='black_list_number_"+k+"']").inputmask("+7(999)999-99-99");
  $('input[name="count_black_list"]').val(k);
});
//Добавление емэйла (настройка уведомлений)
var i = <?=$count_mails?>;
$('.email_more').click(function(e){
  e.preventDefault();
  i++;
  var email_input = '<span class="phone">Ваша эл-почта</span><div class="input-group"> <div class="input-group-addon"><b>@</b></div> <input type="text" class="form-control" name="widget_user_email_'+i+'" placeholder="Email" data-required="true"> </div>';
  $('#emails_block').append(email_input);
  $('input[name="count_emails"]').val(i);
});
//Добавление телефона (определяется при звонке клиенту)
var j = <?=$count_phones?>;
$('.phone_more').click(function(e){
  e.preventDefault();
  j++;
  var phone_input = '<span class="phone">Телефон №'+j+'</span><div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i> </div> <input type="text" class="form-control widget_phone" name="widget_phone_number_'+j+'" placeholder="+7(___)___-__-__" data-required="false"></div>';
  $('#phones_block').append(phone_input);
  $("input[name='widget_phone_number_"+j+"']").inputmask("+7(999)999-99-99");
  $('input[name="count_phones"]').val(j);
});
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
      },
    });
  }
}
</script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>