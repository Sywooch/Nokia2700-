<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  	<meta charset="<?= Yii::$app->charset ?>">
   	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="interkassa-verification" content="692b55e209fc39b0869852b30ee9ca23" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> -->
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<?php $this->beginBody(); ?>
	<div class="wrapper">
		<header class="main-header">
    		<!-- Logo -->
    		<a href="/" class="logo">
      		<!-- mini logo for sidebar mini 50x50 pixels -->
      		<span class="logo-mini"><b>R</b></span>
      		<!-- logo for regular state and mobile devices -->
      		<span class="logo-lg"><b>Robax</b></span>
    		</a>
    		<!-- Header Navbar: style can be found in header.less -->
    		<nav class="navbar navbar-static-top">
      			<!-- Sidebar toggle button-->
      			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        		<span class="sr-only">Скрыть меню</span>
      			</a>
      			<div class="navbar-custom-menu">
        			<ul class="nav navbar-nav">
        				<li class="dropdown">
              				<!-- Menu Toggle Button -->
              				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                				<span class="hidden-xs cache">Баланс: <?=Yii::$app->user->identity->cache?> руб.</span>
              				</a>
              				<ul class="dropdown-menu">
               					<li><a href="<?=Url::to('/profile/pay');?>" class=""><i class="fa fa-credit-card"></i>Пополнение баланса</a></li>
              					<li><a href="<?=Url::to('/profile/pay-history');?>" class=""><i class="fa fa-line-chart"></i>История баланса</a></li>
              				</ul>
            			</li>
            			<li class="dropdown user user-menu">
              				<!-- Menu Toggle Button -->
              				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                			<!-- The user image in the navbar-->
                			<?=Html::img('@web'.'/images/user2-160x160.jpg',['class' => "user-image", 'alt' => 'User Image']); ?>
                			<!-- <img src="/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
                			<!-- hidden-xs hides the username on small devices so only the image appears. -->
                			<span class="hidden-xs user-name"><?=Yii::$app->user->identity->name?></span>
              				</a>
	              			<ul class="dropdown-menu">
			                <!-- The user image in the menu -->
			                
			                <!-- Menu Body -->
			                <!--<li class="user-body">
			                  <div class="row">
			                    <div class="col-xs-4 text-center">
			                      <a href="#">Followers</a>
			                    </div>
			                    <div class="col-xs-4 text-center">
			                      <a href="#">Sales</a>
			                    </div>
			                    <div class="col-xs-4 text-center">
			                      <a href="#">Friends</a>
			                    </div>
			                  </div>
			                </li>-->
			                <!-- Menu Footer-->
								<?=Html::beginForm(['/logout'], 'post', ['class' => 'navbar-form'])
								. Html::endForm() ?>
				                <li class="user-footer">
				                  	<div class="pull-left">
				                    	<a href="<?=Url::to('/profile');?>" class="btn btn-default btn-flat">Профиль</a>
				                  	</div>
					                  <div class="pull-right">
					                    <?=(Html::beginForm(['/site/logout'], 'post')
										. Html::submitButton(
											'Выход',
											['class' => 'btn btn-default btn-flat']
										)
										. Html::endForm())?>
					                  </div>
				                </li>
				             </ul>
				        </li>
          			</ul>
      			</div>
    		</nav>
  		</header>
  		<aside class="main-sidebar">
  			<section class="sidebar">
  				<ul class="sidebar-menu">
        			<!--<li class="header">Меню</li>-->
					<?php $active = (Url::to(['']) == '/profile/index') ? 'active' : ''; ?>
        			<li class="<?=$active?>"><a href="<?=Url::to('/profile');?>"><i class="fa fa-user"></i> <span>Профиль</span></a></li>
					<?php $active = (Url::to(['']) == '/profile/pay' || Url::to(['']) == '/profile/pay-history') ? 'active' : ''; ?>
         			<li class="treeview <?=$active?>">
          				<a href="#">
            				<i class="fa fa-rub"></i> <span>Платежи</span> <i class="fa fa-angle-left pull-right"></i>
          				</a>
				        <ul class="treeview-menu">
				        	<li><a href="<?=Url::to('/profile/pay');?>" class=""><i class="fa fa-credit-card"></i>Пополнение баланса </a></li>
				           	<li><a href="<?=Url::to('/profile/pay-history');?>" class=""><i class="fa fa-line-chart"></i>История баланса </a></li>
				        </ul>
        			</li>
					<?php $active = (Url::to(['']) == '/profile/widgets') ? 'active' : ''; ?>
			        <li class="<?=$active?>">
			        	<a href="<?=Url::to('/profile/widgets');?>">
			            	<i class="fa fa-dashboard"></i> <span>Виджеты</span>
			          	</a>
			      	</li>
					<?php $active = (Url::to(['']) == '/profile/history') ? 'active' : ''; ?>
        			<li class="<?=$active?>">
        				<a href="<?=Url::to('/profile/history');?>">
        					<i class="fa fa-bar-chart"></i> <span>Звонки с виджетов</span>
        				</a>
        			</li>
					<?php $active = (Url::to(['']) == '/profile/analytics') ? 'active' : ''; ?>
					<li class="<?=$active?>">
						<a href="<?=Url::to('/profile/analytics');?>">
							<i class="fa fa-bar-chart"></i> <span>Аналитика</span>
						</a>
					</li>
					<?php $active = (Url::to(['']) == '/partners/index' || Url::to(['']) == '/partners/promo') ? 'active' : ''; ?>
					<li class="treeview <?=$active?>">
						<a href="#">
							<i class="fa fa-users"></i> <span>Партнёрка</span> <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li><a href="<?=Url::to('/partners');?>" class=""><i class="fa fa-bar-chart"></i>Общая информация</a></li>
							<li><a href="<?=Url::to('/partners/promo');?>" class=""><i class="fa fa-image"></i>Промо материалы</a></li>
							<li><a href="<?=Url::to('/partners/bonus-history');?>" class=""><i class="fa fa-line-chart"></i>Бонусный счет</a></li>
						</ul>
					</li>
        		</ul>
    		</section>
  		</aside>
  		<div class="content-wrapper">
  			<?= $content ?>
  		</div>
  		<footer class="main-footer">
		    <div class="pull-right hidden-xs">
		      <b>Version</b> 0.0.1
		    </div>
    		<strong>Авторское право находится за &copy; 2016 <a href="#creaters">SS and BR</a>.</strong> Все права сохранены.
  		</footer>
  	</div>
<?php $this->endBody() ?>
</body>
</html>
<script>
	$('#logout').click(function(){
		$('.navbar-form').submit();
	});
</script>
<?php $this->endPage() ?>