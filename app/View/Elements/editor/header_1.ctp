<?php
if(count($this->Session->read("Auth"))>0){
    $authCompponent = array_values($this->Session->read("Auth"));
    $authCompponent = $authCompponent[0];
}
if(isset($authCompponent['id']) && !empty($authCompponent['id']) && ($this->params['prefix'] == 'editor' || $this->params['prefix'] == 'Editor' )) { ?>
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
                            <div class="icon-frame">
                               <a href="<?php echo Router::fullbaseUrl().'/editor/editors'?>" title="<?php echo __dbt('Dashboard');?>"><i class="fa fa-home"></i></a>
                            </div>
                         </div>
                    </div>
                    <div class="orange-icon dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="user-img">
                        <?php if(AuthComponent::user("File.new_name")){
                            echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name"));}
                                else if($this->Session->read("Auth.File.new_name")) {
                                    echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.$this->Session->read("Auth.File.new_name")); }else {echo $this->Html->image(DEFAULT_PROFILE_IMG);} 
                        ?></span>
                          <span> <?php echo __dbt('Welcome').' '. AuthComponent::User('name');?> <span class="caret"></span></span></a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link(__dbt('Profile'), array('controller' => 'dashboard', 'action' => 'myProfile')); ?><li>
                            <li class="divider"></li>
                            <li><?php  echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout', 'Editor','editor'=>true)); ?></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER END -->
<?php }elseif(!empty($authCompponent) && $authCompponent['role_id'] == 7){?>
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
                            <div class="icon-frame">
                                <!--a href="<?php //echo EDITOR_URL.'/editors'?>" title="<!--?php //echo __dbt('Dashboard');?>"><i class="fa fa-home"></i></a-->
                                <a href="<?php echo Router::fullbaseUrl().'/editor/editors'?>" title="<?php echo __dbt('Dashboard');?>"><i class="fa fa-home"></i></a>
                            </div>
                         </div>
                    </div>
                    <div class="orange-icon dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="user-img">
                        <?php if(AuthComponent::user("File.new_name")){
                            echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name"));}
                                else if($this->Session->read("Auth.File.new_name")) {
                                    echo $this->Html->image(BASE_URL.'img/ProfileImages/thumbnail/'.$this->Session->read("Auth.File.new_name")); }else {echo $this->Html->image(DEFAULT_PROFILE_IMG);} 
                        ?></span>
                          <span> <?php echo __dbt('Welcome').' '. $authCompponent['name'];?> <span class="caret"></span></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="editor/dashboard/myProfile"><?php echo __dbt('Profile');?></a></li>
                            <!--<li><?php //echo $this->Html->link(__dbt('Profile'), array('controller' => 'dashboard', 'action' => 'myProfile')); ?><li>-->
                            <li class="divider"></li>
                            <li><?php  echo $this->Html->link(__dbt('Log Out'), array('controller' => 'users', 'action' => 'logout', 'Editor','editor'=>true)); ?></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER END -->
<?php } ?>
