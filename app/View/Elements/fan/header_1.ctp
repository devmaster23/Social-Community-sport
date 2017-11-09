<!-- HEADER -->
<header class="header dark-header newHeader">
    <div class="container">
            <div class="row">
            <div class="col-xs-6 col-sm-5 header-space">
                <?php if($this->params['action'] != 'news') { ?>
                <a href="<?php echo HTTP_ROOT;?>"><img style="margin-left:-30px;margin-top:-7px;display:inline-block;" src="/img/sports-logo.png" alt="Sports" /></a>
                <?php } ?>
            </div>
            <div class="col-xs-6 col-sm-7">
                    <div class="right-frame">
                    
                    <div class="header-space pull-left">
                        <div class="icon-frame position-rel">
                            <?php if(AuthComponent::User('sportSession.wall_id') != '') { ?>
                            <div class="icon-frame">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true" title="<?php echo __dbt('Notification');?>"><i class="fa fa-envelope-o"></i></a>
                                <?php echo $this->Notification->getNotificationCount(AuthComponent::User('sportSession.wall_id'));?>
                                <ul class="dropdown-menu drp-not-set">
                                    <?php echo $this->Notification->showFanPostNotification(AuthComponent::User('sportSession.wall_id'));?>  
                                </ul>
                            </div>                                
                            <?php } ?> 
                            <div class="icon-frame">
                                <a href="<?php echo BASE_URL.'dashboard'?>" title="<?php echo __dbt('Dashboard');?>"><i class="fa fa-home"></i></a>
                            </div>
                         </div>
                     </div>
                   
                     
                    <div class="orange-icon dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="user-img">
                        <?php if(AuthComponent::user("File.new_name")){ echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name"));}
                                else if($this->Session->read("Auth.File.new_name")) { 
                                    echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.$this->Session->read("Auth.File.new_name")); } 
                                        else { 
                                            echo $this->Html->image(DEFAULT_PROFILE_IMG);} ?>
                        </span>
                          <span> <?php  echo __dbt('Welcome').' '. AuthComponent::User('name');?> <span class="caret"></span></span></a>
                      <ul class="dropdown-menu drp-not-set">

                        <?php if($this->Session->read('Auth.User.role_id') == 6){  ?>
                        <li><?php echo $this->Html->link(__dbt('Profile'), array('controller' => 'dashboard', 'action' => 'myProfile','blogger'=>true)); ?></li>
                        <li class="divider"></li>
                        <li><?php echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout','blogger'=>true)); ?></li>
                        	<?php   } else { ?>
                                <li><?php echo $this->Html->link(__dbt('Profile'), array('controller' => 'dashboard', 'action' => 'myProfile')); ?></li>
                                <li class="divider"></li>
                                <li><?php  echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout')); ?></li>
                             <?php } ?>
                      </ul>
                    

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
