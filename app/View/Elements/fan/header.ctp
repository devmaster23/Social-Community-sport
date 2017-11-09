<!-- HEADER -->
 <!-- TOP BAR -PHONE EMAIL AND TOP MENU -->
    <section class="i-head-top">
        <div class="i-head row">
            
                        <div class="i-head-left i-head-com col-md-6">
                <ul>
                    <li><a href="/"><img class="logo-header" src="/images/logo.png" alt=""></a></li>
                </ul>
            </div>
            
                                <!--div class="col-md-3 top-search">
                        <form>
                            <ul>
                                <li>
                                    <input type="text" placeholder="Search Here..">
                                </li>
                                <li>
                                    <input type="submit" value="search">
                                </li>
                            </ul>
                        </form>
                    </div-->
            
                    <div class="i-head-right i-head-com col-md-6 col-sm-12 col-xs-12">
                    
                 
                        <ul> <li class="top-scal"><a href="<?php echo BASE_URL.'dashboard'?>" title="<?php echo __dbt('Dashboard');?>"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __dbt('Dashboard');?></a></li>

                        
                
                   
    
                     <li class="top-scal-1"><a href="#" class="tr-menu"><i class="fa fa-chevron-down" aria-hidden="true"></i>  <?php  echo __dbt('Welcome').' '. AuthComponent::User('name');?> </a>
                        
                     <li>           <?php if(AuthComponent::User('sportSession.wall_id') != '') { ?>
                            <div class="icon-frame">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true" title="<?php echo __dbt('Notification');?>"><i class="fa fa-envelope-o"></i></a>
                                <?php echo $this->Notification->getNotificationCount(AuthComponent::User('sportSession.wall_id'));?>
                                <ul class="dropdown-menu drp-not-set notification-drop">
                                    <?php echo $this->Notification->showFanPostNotification(AuthComponent::User('sportSession.wall_id'));?>  
                                </ul>
                            </div>                                
                            <?php } ?> 
                     </li>
                        
                        </ul>
                     
                                    <div class="cat-menu">
                                        <div class="cbb2-home-nav-bot">
                                            <ul class="headerdropdown">

                                          <li>
                                              <span class="user-img">
                        <?php if(AuthComponent::user("File.new_name")){ echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name"));}
                                else if($this->Session->read("Auth.File.new_name")) { 
                                    echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.$this->Session->read("Auth.File.new_name")); } 
                                        else { 
                                            echo $this->Html->image(DEFAULT_PROFILE_IMG);} ?>
                        </span>
                         
                                          </li>
                                          
                                          
                        <?php if($this->Session->read('Auth.User.role_id') == 6){  ?>
                        <li><?php echo $this->Html->link(__dbt('Profile'), array('controller' => 'dashboard', 'action' => 'myProfile','blogger'=>true)); ?></li>
                        
                        <li><?php echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout','blogger'=>true)); ?></li>
                        	<?php   } else { ?>

                            <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-tachometer')) . __dbt("Dashboard"),array('controller' => 'dashboard', 'action' => 'index'),array('escape' => false)); ?>
    </li>
    <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-user-secret')) . __dbt("Profile Settings"),array('controller' => 'dashboard', 'action' => 'myProfile'),array('escape' => false)); ?>
    
    </li>
                                <li><?php  echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout')); ?></li>
                             <?php } ?>
                      </ul>
             
                </div>
                        </div>
                     

                    

           
                </div>
                 </div>
    </section>

