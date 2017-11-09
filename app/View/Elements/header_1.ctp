<?php
if(count($this->Session->read("Auth"))>0){
    $authCompponent = array_values($this->Session->read("Auth"));
    $authCompponent = $authCompponent[0];
}

if(isset($authCompponent['id']) && !empty($authCompponent['id'])) { ?>
    <?php if($authCompponent['role_id'] == 1 || $authCompponent['role_id'] == 2 || $authCompponent['role_id'] == 3 || $authCompponent['role_id'] == 4 ){  ?>
    <header class="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-5 header-space">
                    <div id="nav_list"><i class="fa fa-bars"></i> <i class="fa fa-times"></i></div>
                    <?php if($this->params['action'] != 'news') { ?>
                    <a href="<?php echo HTTP_ROOT;?>"><img style="margin-left:-30px;margin-top:-7px;display:inline-block;" src="/img/sports-logo.png" alt="Sports" /></a>
                    <?php } ?>
            </div>
            <div class="col-xs-6 col-sm-7 header-space">
                <?php if($this->params['action']!='blogger_login' &&  $this->params['action']!='editor_login' && $this->params['action']!='login' ){?>
                    <div class="right-frame">
                            <div class="icon-frame" id="navigation-bar" data-toggle="tooltip" title="Search">
                            <?php 
                            if(($this->params['controller'] == 'pages' || $this->params['controller'] == 'Sports') && ($this->params['action'] == 'home' || $this->params['action'] == 'sport'))
                            {   
                                echo $this->Form->create('News',array('id'=>"search",'class'=>'form-horizontal','novalidate')); ?>
                                <div id="label"><label for="search-terms" id="search-label"><i class="fa fa-search" title="<?php echo __dbt('Search');?>"></i></label></div>
                                <div id="input"><?php echo $this->Form->input('search',array('class'=>'form-control','id'=>'search-terms','placeholder'=>__dbt('Enter search terms...'),'label' => false)); ?>
                                    <a href="javascript:void(0);"><i class="fa fa-times"></i></a></div>
                            <?php echo $this->Form->end();  
                            } ?>
                            </div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Video Uploader Login');?>"><a data-toggle="modal" data-target="#blog-log-in" href="javascript:void(0);"><i class="fa fa-video-camera"></i></a></div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Editor Login');?>"><a data-toggle="modal" data-target="#editor-log-in" href="javascript:void(0);"><i class="fa fa-newspaper-o"></i></a></div>
                            <div id="loginError" class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Fan Login');?>"><a data-toggle="modal" data-target="#log-in" href="javascript:void(0);"><i class="fa fa-unlock-alt"></i></a></div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Fan Registration');?>"><a data-toggle="modal" data-target="#sign-up" href="javascript:void(0);"><i class="fa fa-user"></i></a></div>

                    <div class="icon-frame" data-toggle="tooltip" id="polyglotLanguageSwitcher" title="<?php echo __dbt('Language');?>">
                        <form action="#">
                            <select>
                                <?php $lang = $this->Session->read("Config.language");
                                    if($lang == "hin"){
                                        echo <<<EOD
                                    <option class="eng" id="en" value="eng" >English</option>
                                    <option class="hin" id="hi" value="hin" selected>हिंदी</option>
                                    
EOD;
                                    }else{
                                        echo <<<EOD
                                    <option class="eng" id="en" value="eng" selected>English</option>
                                    <option class="hin" id="hi" value="hin">हिंदी</option>
EOD;
                                    }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
            <?php }?>
            </div>
        </div>
    </div>
    </header>

    <?php }else{ ?>
           
    <?php if($authCompponent['role_id'] !="" && $authCompponent['role_id'] == 6 && ($this->params['prefix'] == 'blogger' || $this->params['prefix'] == 'Blogger')){ 
            echo $this->element('blogger/header');
        }elseif ($authCompponent['role_id'] !="" && $authCompponent['role_id'] == 7 && ($this->params['prefix'] == 'editor' || $this->params['prefix'] == 'Editor')){ 
           echo $this->element('editor/header');
        }else{
    ?>
    <!-- HEADER -->
    <header class="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-5 header-space">
                    <div id="nav_list"><i class="fa fa-bars"></i> <i class="fa fa-times"></i></div>
                    <?php if($this->params['action'] != 'news') { ?>
                    <a href="<?php echo HTTP_ROOT;?>"><img style="margin-left:-30px;margin-top:-7px;display:inline-block;" src="/img/sports-logo.png" alt="Sports" /></a>
                    <?php } ?>
            </div>
            <div class="col-xs-6 col-sm-7 header-space">
                <?php if($this->params['action']!='blogger_login' &&  $this->params['action']!='editor_login' && $this->params['action']!='login' ){?>
                    <div class="right-frame">
                            <div class="icon-frame" id="navigation-bar" data-toggle="tooltip" title="Search">
                            <?php 
                            if(($this->params['controller'] == 'pages' || $this->params['controller'] == 'Sports') && ($this->params['action'] == 'home' || $this->params['action'] == 'sport'))
                            {   
                                echo $this->Form->create('News',array('id'=>"search",'class'=>'form-horizontal','novalidate')); ?>
                                <div id="label"><label for="search-terms" id="search-label"><i class="fa fa-search" title="<?php echo __dbt('Search');?>"></i></label></div>
                                <div id="input"><?php echo $this->Form->input('search',array('class'=>'form-control','id'=>'search-terms','placeholder'=>__dbt('Enter search terms...'),'label' => false)); ?>
                                    <a href="javascript:void(0);"><i class="fa fa-times"></i></a></div>
                            <?php echo $this->Form->end();  
                            } ?>
                            </div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Video Uploader Login');?>"><a data-toggle="modal" data-target="#blog-log-in" href="javascript:void(0);"><i class="fa fa-video-camera"></i></a></div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Editor Login');?>"><a data-toggle="modal" data-target="#editor-log-in" href="javascript:void(0);"><i class="fa fa-newspaper-o"></i></a></div>
                            <div id="loginError" class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Fan Login');?>"><a data-toggle="modal" data-target="#log-in" href="javascript:void(0);"><i class="fa fa-unlock-alt"></i></a></div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Fan Registration');?>"><a data-toggle="modal" data-target="#sign-up" href="javascript:void(0);"><i class="fa fa-user"></i></a></div>

                    <div class="icon-frame" data-toggle="tooltip" id="polyglotLanguageSwitcher" title="<?php echo __dbt('Language');?>">
                        <form action="#">
                            <select>
                                <?php $lang = $this->Session->read("Config.language");
                                    if($lang == "hin"){
                                        echo <<<EOD
                                    <option class="eng" id="en" value="eng" >English</option>
                                    <option class="hin" id="hi" value="hin" selected>हिंदी</option>
                                    
EOD;
                                    }else{
                                        echo <<<EOD
                                    <option class="eng" id="en" value="eng" selected>English</option>
                                    <option class="hin" id="hi" value="hin">हिंदी</option>
EOD;
                                    }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
            <?php }?>
            </div>
        </div>
    </div>
    </header>
    <!-- HEADER END -->
    <?php } ?>
<?php } ?>
<?php } else { ?>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-5 header-space">
                    <div id="nav_list"><i class="fa fa-bars"></i> <i class="fa fa-times"></i></div>
                    <?php if($this->params['action'] != 'news') { ?>
                    <a href="<?php echo HTTP_ROOT;?>"><img style="margin-left:-30px;margin-top:-7px;display:inline-block;" src="/img/sports-logo.png" alt="Sports" /></a>
                    <?php } ?>
            </div>
            <div class="col-xs-6 col-sm-7 header-space">
                <?php if($this->params['action']!='blogger_login' &&  $this->params['action']!='editor_login' && $this->params['action']!='login' ){?>
                    <div class="right-frame">
                            <div class="icon-frame" id="navigation-bar" data-toggle="tooltip" title="Search">
                            <?php 
                            if(($this->params['controller'] == 'pages' || $this->params['controller'] == 'Sports') && ($this->params['action'] == 'home' || $this->params['action'] == 'sport'))
                            {   
                                echo $this->Form->create('News',array('id'=>"search",'class'=>'form-horizontal','novalidate')); ?>
                                <div id="label"><label for="search-terms" id="search-label"><i class="fa fa-search" title="<?php echo __dbt('Search');?>"></i></label></div>
                                <div id="input"><?php echo $this->Form->input('search',array('class'=>'form-control','id'=>'search-terms','placeholder'=>__dbt('Enter search terms...'),'label' => false)); ?>
                                    <a href="javascript:void(0);"><i class="fa fa-times"></i></a></div>
                            <?php echo $this->Form->end();  
                            } ?>
                            </div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Video Uploader Login');?>"><a data-toggle="modal" data-target="#blog-log-in" href="javascript:void(0);"><i class="fa fa-video-camera"></i></a></div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Editor Login');?>"><a data-toggle="modal" data-target="#editor-log-in" href="javascript:void(0);"><i class="fa fa-newspaper-o"></i></a></div>
                            <div id="loginError" class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Fan Login');?>"><a data-toggle="modal" data-target="#log-in" href="javascript:void(0);"><i class="fa fa-unlock-alt"></i></a></div>
                            <div class="icon-frame" data-toggle="tooltip" title="<?php echo __dbt('Fan Registration');?>"><a data-toggle="modal" data-target="#sign-up" href="javascript:void(0);"><i class="fa fa-user"></i></a></div>

                    <div class="icon-frame" data-toggle="tooltip" id="polyglotLanguageSwitcher" title="<?php echo __dbt('Language');?>">
                        <form action="#">
                            <select>
                                <?php $lang = $this->Session->read("Config.language");
                                    if($lang == "hin"){
                                        echo <<<EOD
                                    <option class="eng" id="en" value="eng" >English</option>
                                    <option class="hin" id="hi" value="hin" selected>हिंदी</option>
                                    
EOD;
                                    }else{
                                        echo <<<EOD
                                    <option class="eng" id="en" value="eng" selected>English</option>
                                    <option class="hin" id="hi" value="hin">हिंदी</option>
EOD;
                                    }
                                ?>
                                    

                            </select>
                        </form>
                    </div>
                </div>
            <?php }?>
            </div>
        </div>
    </div>
</header>
<?php } ?>

<script>
  $(document).ready(function(){
   $(".right-frame #input").click(function(){
    $(this).addClass("focus");
    }); 
   });  
    
</script>