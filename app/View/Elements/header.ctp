 <!-- TOP BAR -PHONE EMAIL AND TOP MENU -->
    <section class="i-head-top">
        <div class="i-head row">
            <!-- TOP CONTACT INFO -->
            <div class="i-head-left i-head-com col-md-6">
                <ul>
                    <li><a href="/"><img class="logo-header" src="/images/logo.png" alt=""></a></li>
                </ul>
            </div>
            <!-- TOP FIXED MENU -->
            <div class="i-head-right i-head-com col-md-6 col-sm-12 col-xs-12">
                <ul>
                    
                    <?php
if(count($this->Session->read("Auth"))>0){
    $authCompponent = array_values($this->Session->read("Auth"));
    $authCompponent = $authCompponent[0];
}

if(isset($authCompponent['id']) && !empty($authCompponent['id'])) { ?>
    <?php if($authCompponent['role_id'] == 1 || $authCompponent['role_id'] == 2 || $authCompponent['role_id'] == 3 || $authCompponent['role_id'] == 4 ){  ?>

           
                <?php if($this->params['action']!='blogger_login' &&  $this->params['action']!='editor_login' && $this->params['action']!='login' ){?>
                    <div class="right-frame">
        

                            <li class="top-scal"><a data-toggle="modal" data-target="#blog-log-in" href="javascript:void(0);" title="<?php echo __dbt('Video Uploader Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Video Uploader Login');?></a></li>
                            <li class="top-scal-1"><a data-toggle="modal" data-target="#editor-log-in" href="javascript:void(0);" title="<?php echo __dbt('Editor Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Editor Login');?></a></li>
                            <li class="top-scal-2"><a data-toggle="modal" data-target="#log-in" href="javascript:void(0);" title="<?php echo __dbt('Fan Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Fan Login');?></a></li>
                            <li class="top-scal-3"><a data-toggle="modal" data-target="#sign-up" href="javascript:void(0);" title="<?php echo __dbt('Fan Registration');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Fan Registration');?></a></li>
                            
                      <li class="top-scal-4"> <div class="icon-frame" data-toggle="tooltip" id="polyglotLanguageSwitcher" title="<?php echo __dbt('Language');?>">
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

                    </li>
                            
    
                </div>
            <?php }?>
    
  

    <?php }else{ ?>
           
    <?php if($authCompponent['role_id'] !="" && $authCompponent['role_id'] == 6 && ($this->params['prefix'] == 'blogger' || $this->params['prefix'] == 'Blogger')){ 
            echo $this->element('blogger/header');
        }elseif ($authCompponent['role_id'] !="" && $authCompponent['role_id'] == 7 && ($this->params['prefix'] == 'editor' || $this->params['prefix'] == 'Editor')){ 
           echo $this->element('editor/header');
        }else{
    ?>
    <!-- HEADER -->
   
                <?php if($this->params['action']!='blogger_login' &&  $this->params['action']!='editor_login' && $this->params['action']!='login' ){?>
                      <div class="right-frame">
        

                            <li class="top-scal"><a data-toggle="modal" data-target="#blog-log-in" href="javascript:void(0);" title="<?php echo __dbt('Video Uploader Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Video Uploader Login');?></a></li>
                            <li class="top-scal-1"><a data-toggle="modal" data-target="#editor-log-in" href="javascript:void(0);" title="<?php echo __dbt('Editor Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Editor Login');?></a></li>
                            <li class="top-scal-2"><a data-toggle="modal" data-target="#log-in" href="javascript:void(0);" title="<?php echo __dbt('Fan Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Fan Login');?></a></li>
                            <li class="top-scal-3"><a data-toggle="modal" data-target="#sign-up" href="javascript:void(0);" title="<?php echo __dbt('Fan Registration');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Fan Registration');?></a></li>
                            
                      <li class="top-scal-4"> <div class="icon-frame" data-toggle="tooltip" id="polyglotLanguageSwitcher" title="<?php echo __dbt('Language');?>">
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

                    </li>
                            
    
                </div>
            <?php }?>
          
     
    <!-- HEADER END -->
    <?php } ?>
<?php } ?>
<?php } else { ?>

           
                <?php if($this->params['action']!='blogger_login' &&  $this->params['action']!='editor_login' && $this->params['action']!='login' ){?>
              <div class="right-frame">
        

                            <li class="top-scal"><a data-toggle="modal" data-target="#blog-log-in" href="javascript:void(0);" title="<?php echo __dbt('Video Uploader Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Video Uploader Login');?></a></li>
                            <li class="top-scal-1"><a data-toggle="modal" data-target="#editor-log-in" href="javascript:void(0);" title="<?php echo __dbt('Editor Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Editor Login');?></a></li>
                            <li class="top-scal-2"><a data-toggle="modal" data-target="#log-in" href="javascript:void(0);" title="<?php echo __dbt('Fan Login');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Fan Login');?></a></li>
                            <li class="top-scal-3"><a data-toggle="modal" data-target="#sign-up" href="javascript:void(0);" title="<?php echo __dbt('Fan Registration');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Fan Registration');?></a></li>
                            
                      <li class="top-scal-4"><div class="icon-frame" data-toggle="tooltip" id="polyglotLanguageSwitcher" title="<?php echo __dbt('Language');?>">
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
               

                    </li>
                            
    
                </div>
            <?php }?>
        

<?php } ?>

     </ul>
            </div>
        </div>
    </section>
   
    
    
<script>
  $(document).ready(function(){
   $(".right-frame #input").click(function(){
    $(this).addClass("focus");
    }); 
   });  
    
</script>