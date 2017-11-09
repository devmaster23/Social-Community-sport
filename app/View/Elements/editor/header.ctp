<?php
if(count($this->Session->read("Auth"))>0){
    $authCompponent = array_values($this->Session->read("Auth"));
    $authCompponent = $authCompponent[0];
} ?>
    <section class="i-head-top">
        <div class="i-head row">

<?php if(isset($authCompponent['id']) && !empty($authCompponent['id']) && ($this->params['prefix'] == 'editor' || $this->params['prefix'] == 'Editor' )) { ?>
<!-- HEADER -->


                
                                       <div class="i-head-left i-head-com col-md-6">
                <ul>
                    <li><a href="<?php echo HTTP_ROOT;?>"><img class="logo-header" src="/img/sports-logo.png" alt="Sports" ></a></li>
                </ul>
            </div>
          

<div class="i-head-right i-head-com col-md-6 col-sm-12 col-xs-12">
    <ul>
        <li class="top-scal"><a href="<?php echo Router::fullbaseUrl().'/editor/editors'?>" title="<?php echo __dbt('Dashboard');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Dashboard');?></a></li>

                       <li class="top-scal-1"><a href="#" class="tr-menu"><i class="fa fa-chevron-down" aria-hidden="true"></i> <?php echo __dbt('Welcome').' '. AuthComponent::User('name');?> </a>

    </ul>
         <div class="cat-menu">
                                        <div class="cbb2-home-nav-bot">
                                            <ul class="headerdropdown">
                                                <li>      <?php if(AuthComponent::user("File.new_name")){
                            echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name"));}
                                else if($this->Session->read("Auth.File.new_name")) {
                                    echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.$this->Session->read("Auth.File.new_name")); }else {echo $this->Html->image(DEFAULT_PROFILE_IMG);} 
                        ?></li>
                                                 <li><?php echo $this->Html->link(__dbt('Profile'), array('controller' => 'dashboard', 'action' => 'myProfile')); ?><li>
                            <li><?php  echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout', 'Editor','editor'=>true)); ?></li>
                       
                                            </ul>
                                        </div>
         </div>
</div>


                
 
  
<!-- HEADER END -->
<?php }elseif(!empty($authCompponent) && $authCompponent['role_id'] == 7){?>
<!-- HEADER -->

 <?php if($this->params['action'] != 'news') { ?>
                      <div class="i-head-left i-head-com col-md-6">
                <ul>
                    <li><a href="<?php echo HTTP_ROOT;?>"><img src="/img/sports-logo.png" alt="Sports" /></a></li>
                </ul>
            </div>
           <?php } ?>

            
                    <div class="i-head-right i-head-com col-md-6 col-sm-12 col-xs-12">
                    
                 
                        <ul> <li class="top-scal"><a href="<?php echo Router::fullbaseUrl().'/editor/editors'?>" title="<?php echo __dbt('Dashboard');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Dashboard');?></a></li>

                       <li class="top-scal-1"><a href="#" class="tr-menu"><i class="fa fa-chevron-down" aria-hidden="true"></i>  <?php echo __dbt('Welcome').' '. $authCompponent['name'];?> </a>

                        </ul>
                               <div class="cat-menu">
                                        <div class="cbb2-home-nav-bot">
                                            <ul class="headerdropdown">
                                                <li>           <?php if(AuthComponent::user("File.new_name")){
                            echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name"));}
                                else if($this->Session->read("Auth.File.new_name")) {
                                    echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.$this->Session->read("Auth.File.new_name")); }else {echo $this->Html->image(DEFAULT_PROFILE_IMG);} 
                        ?></li>
                                                     <li><a href="editor/dashboard/myProfile"><?php echo __dbt('Profile');?></a></li>
                            <!--<li><?php //echo $this->Html->link(__dbt('Profile'), array('controller' => 'dashboard', 'action' => 'myProfile')); ?><li>-->
                            <li><?php  echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout', 'Editor','editor'=>true)); ?></li>
                        
                                            </ul>
                                        </div>
                               </div>

  </div>
<!-- HEADER END -->
<?php } ?>
        </div>
    </section>