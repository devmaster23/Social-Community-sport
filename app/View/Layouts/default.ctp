<?php
$cakeDescription = __d('cake_dev', 'FansWage');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META TAGS -->
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
      <?php
        if($this->params['action'] == 'news')
        {
            $pageUrl = Router::url($this->here, true);
            $pageDescription = $news['News']['description'];
            $shareImgUrl = $news['File']['path'];
            ?>
            <meta property="fb:app_id" content="207270666293501" />
            <!-- Default -->
            <meta property="og:title" content="FansWage: News" />
            <meta property="og:site_name" content="FansWage" />
            <meta property="og:url" content="<?php echo $pageUrl; ?>" />
            <meta property="og:description" content="<?php echo $pageDescription ?>" />
            <meta property="og:image" content="<?php echo $shareImgUrl ?>" />
            
            <meta name="twitter:card" content="FansWage">
            <meta name="twitter:url" content="<?php echo $pageUrl; ?> ">
            <meta name="twitter:title" content="FansWage: News">
            <meta name="twitter:description"
            	content="<?php echo $pageDescription ?>">
            <meta name="twitter:image" content="<?php echo $shareImgUrl ?>">

            <?php
        }
        
             echo $this->Html->script(array('front/jquery.min','jquery-ui','front/bootstrap.min','front/jquery.flexslider-min','front/parallax-background','front/search','front/jquery.validate','front/jquery.polyglot.language.switcher','jquery.validate.min',
            '64'
        ));
           echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        require_once (WWW_ROOT . 'js/sportsfront.php');
        ?>
    
    
    <!-- FAV ICON(BROWSER TAB ICON) -->
    <link rel="shortcut icon" href="images/fav.ico" type="image/x-icon">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700%7CMontserrat:300,500%7COswald:400,500" rel="stylesheet">

    <!-- FONTAWESOME ICONS -->
    <link rel="stylesheet" href="/css/font-awesome.min.css">

    <!-- ALL CSS FILES -->
    
  
        <link rel="stylesheet" href="/css/bootstrap.css">

    <link rel="stylesheet" href="/css/style.css">

    <!-- MOB.CSS ONLY FOR MOBILE AND TABLET VIEWS -->
    <link rel="stylesheet" href="/css/mob.css">
<link rel="stylesheet" href="/css/custom.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
   <?php
    if($this->Session->check('Auth.User'))
    {
        $class = 'addbody';
    }
    else
    {
        $class = 'pushmenu-push';
    }
    ?>
<body  class="<?php echo $class; ?>">

	<!-- NAVIGATION -->

      <?php echo $this->element('sportMenu'); ?>
   
        
        
        
        
        <?php
        
                if(!isset($elementFolder) || empty($elementFolder))
            {
                $elementFolder = NULL;
            }
            
            if($this->Session->check('Auth'))
            {
                $authCompponent = array_values($this->Session->read("Auth"));
            }
            
            if($this->request->params['controller'] == 'Sports' && $this->request->params['action'] == 'sport' && AuthComponent::User('id'))
            {
                $authCompponent = array_values($this->Session->read("Auth"));
                if($authCompponent[0]["role_id"] == 6 || $authCompponent[0]["role_id"] == 7)
                {
                    echo $this->element('header');
                }
                else
                {
                    echo $this->element($elementFolder . '/header');
                }
            }
            else
            {
                if(isset($authCompponent[0]['role_id']))
                {
                    if(! empty($authCompponent[0]) && $authCompponent[0]['role_id'] == 6 && $this->request->params['action'] != 'login')
                    {
                        echo $this->element('blogger/header');
                    }
                    elseif(! empty($authCompponent[0]) && $authCompponent[0]['role_id'] == 7 && $this->request->params['action'] != 'login')
                    {
                        echo $this->element('editor/header');
                    }
                    else
                    {
                        echo $this->element($elementFolder . '/header');
                    }
                }
                else
                {
                    echo $this->element($elementFolder . '/header');
                }
            }
            
        ?>
        
        
 
      <?php echo $this->fetch('content');  ?>
    
      <?php echo $this->element('footer'); ?>
 

    <script src="/js/custom.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
                    effect: 'fade',
                    testMode: true,
                    onChange: function (evt) {

                    }
                });
            });
        </script>
</body>

</html>