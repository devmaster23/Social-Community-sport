<?php
$cakeDescription = __d('cake_dev', 'FansWage');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
	    <?php echo $this->Html->charset(); ?>
	    <title><?php echo $this->fetch('title'); ?></title>
	    <?php
	        echo $this->Html->css(array('front/bootstrap.min' ));
	    ?>
	</head>

	<body class="pushmenu-push">
	    <a href="javascript:history.go(-1)">
	        <img src="<?php echo BASE_URL.'/img/404_img.jpg'?>" alt="Page not found" style="width: 100%" />
	    </a>
 	</body>
</html>