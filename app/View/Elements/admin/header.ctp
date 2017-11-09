<?php ?>
<!-- Logo -->
<a href="<?php echo Router::url('/admin/dashboard'); ?>" class="logo">
	<!-- mini logo for sidebar mini 50x50 pixels -->
  	<span class="logo-mini"><b>F</b>W</span>
  	<!-- logo for regular state and mobile devices -->
  	<span class="logo-lg"><b>Fans</b>Wage</span>
</a>

<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only"><?php echo ('Toggle navigation'); ?></span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">  
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <?php $count = $this->Notification->showRejoinNotification($id= null);?>
                    <span class="label label-warning"><?php echo $count; ?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="header"><?php echo ('You have '. $count. ' notifications'); ?> </li>
                    <li>
                        <ul class="menu">
                            <li> 
                                <a href="<?php echo BASE_URL.$this->request->params['prefix'].'/userTeams/rejoinTeamRequest/'?>">
                                    <i class="fa fa-users text-aqua"></i><?php echo ($count. ' members sent rejoin team request.'); ?> 
                                </a>
                            </li> 
                        </ul>
                    </li>
                    
                </ul>
            </li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <?php if(AuthComponent::user("File.new_name")) { 
                $profileImg =  BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name");    
                } else {
                $profileImg = BASE_URL.'img/default_profile.png';    
                }
                ?>
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <img src="<?php echo $profileImg; ?>" class="user-image" alt="User Image">
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs"><?php  echo $this->Session->read('Auth.Admin.name');?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                        
                        <img src="<?php echo $profileImg; ?>" class="img-circle" alt="User Image">
                        <p>
                            <?php  echo $this->Session->read('Auth.Admin.name');?>
                            <small>Since <?php  echo date('M Y',strtotime($this->Session->read('Auth.Admin.created')));?></small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <?php echo $this->Html->link(("Profile"), array("controller"=>"dashboard", "action"=>"admin_myProfile"), array("escape"=>false, "class"=>"btn btn-default btn-flat")); ?>
                        </div>
                        <div class="pull-right">
                            <?php
                                echo $this->Html->link("Logout", array("controller"=>"admins", "action"=>"logout", "admin"=>false, AuthComponent::password("Admin")),array("class"=>"btn btn-default btn-flat"));
                            ?>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
        </ul>
    </div>
</nav>

