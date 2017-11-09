<?php
$cakeDescription = __d('cake_dev', 'FansWage');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>

		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		
		echo $this->Html->css(array('bootstrap.min','ionicons.min','AdminLTE.min','skins/skin-blue.min','datetimepicker','admin-custom'));
                echo $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
		
                echo $this->Html->script(array('jquery-1.11.3.min', 'jquery-ui','jquery.validate.min','sportsvalidate', 'DateTimePicker','bootstrap.min', 'dist/js/app.min', '64'));
                // echo $this->Html->script('https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<?php echo $this->element($elementFolder.'/header'); ?>
		</header>
		<?php echo $this->Flash->render(); ?>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
		  <?php echo $this->element($elementFolder.'/sidebar'); ?>
		<!-- /.sidebar -->
		</aside>  
		<div class="content-wrapper">
			<?php echo $this->fetch('content'); ?>
		</div>
		<?php //echo $this->element('sql_dump'); ?>
	</div>
	
</body>
</html>
