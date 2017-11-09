<?php
$cakeDescription = __d('cake_dev', 'FansWage');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $this->fetch('title'); ?></title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
        echo $this->Html->meta('icon');
        
        echo $this->Html->css(array('front/bootstrap.min.css','front/font-awesome.min', 'front/flexslider', 'front/master','front/polyglot-language-switcher','front/flipper'
        ));
        echo $this->Html->script(array('front/jquery.min','jquery-ui','front/bootstrap.min','front/jquery.flexslider-min','front/parallax-background','front/search','front/jquery.validate','front/jquery.polyglot.language.switcher','jquery.validate.min',
            '64'
        ));
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        require_once (WWW_ROOT . 'js/sportsfront.php');
        ?>

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
    <body class="<?php echo $class; ?>">

	<!-- NAVIGATION -->

        <?php
        if(! $this->Session->check('Auth.User'))
        {
            ?>
            <nav class="pushmenu pushmenu-left">
                <?php echo $this->element('sportMenu'); ?>
            </nav>
        <?php
        
}
        ?>


        <!-- NAVIGATION END -->
	<!-- MAIN CONTENT -->
	<!-- <div class="main-container">   -->
        
            <?php //echo '<pre>'; print_r($_SESSION); die; ?>
            <?php //if(AuthComponent::user('id'))  echo $this->element($elementFolder.'/navigation');  ?>

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
            
            echo $this->fetch('content');
            ?>
        <!-- </div>   -->
        <?php echo $this->element('footer'); ?>


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
