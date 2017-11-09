<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php
        echo $this->Html->meta('icon');

        //echo $this->Html->css(array('front/bootstrap.min', "front/font-awesome.min", "front/flexslider", "front/flipper", "front/master", "front/base-min", "front/brawler", "front/reset-fonts", "front/jquery.tagit"));
        //<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        //echo $this->Html->script(array('jquery-1.11.3.min', 'jquery-ui','jquery.validate.min','sportsfrountjs', '64'));
        //<!-- Include all compiled plugins (below), or include individual files as needed -->
        //echo $this->Html->script(array("front/modernizr", "front/bootstrap.min", "front/jquery.flexslider-min", "front/parallax-background", "front/search",'front/jquery.validate','front/tag-it'));
		
		echo $this->Html->css(array('front/bootstrap.min', 'front/font-awesome.min', 'front/flexslider', 'front/master', 'front/flipper'));
		echo $this->Html->script(array('front/jquery.min', 'front/bootstrap.min', 'front/jquery.flexslider-min', 'front/parallax-background', 'front/search', 'front/jquery.validate', 'jquery.validate.min','64'));    
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
	require_once(WWW_ROOT.'js/sportsfront.php');
    ?>
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="pushmenu-push">
    <main>
        <!-- NAVIGATION -->
        <nav class="pushmenu pushmenu-left">
            <?php echo $this->element('sportMenu'); ?>
        </nav>
        <!-- NAVIGATION END -->
        <!-- MAIN CONTENT -->
        <div class="main-container">    
        
                <?php 
                
                echo $this->element($elementFolder.'/header');
                    
                 ?>

                <?php echo $this->fetch('content'); ?>
        </div>  
            <?php echo $this->element($elementFolder.'/footer'); ?>
            
     </main>      
 </body>
</html>