<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<?php if(AuthComponent::user("File.new_name")) { 
              $profileImg =  BASE_URL.'img/ProfileImages/thumbnail/'.AuthComponent::user("File.new_name");    
              } else {
              $profileImg = BASE_URL.'img/default_profile.png';    
              }
              ?>  
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="<?php echo $profileImg; ?>" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p><?php  echo $this->Session->read('Auth.Team.name');?></p>
    </div>
  </div>
  <!-- Sidebar Menu -->
  <ul class="sidebar-menu">
    
    <li class="header"><?php echo __dbt('MAIN NAVIGATION'); ?></li>
    
    <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-video-camera')) . "<span>".__dbt('List Video')."</span>",array('controller' => 'walls', 'action' => 'index'),array('escape' => false)); ?></li>
    <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-th-large')) . "<span>".('Team Wall')."</span>",array(),array('escape' => false)); ?>
        <ul class="treeview-menu" >
          <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".__dbt('My Post')."</span>",array('controller' => 'walls', 'action' => 'post'),array('escape' => false)); ?></li>
          <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-user-plus')) . "<span>".__dbt('Add Post')."</span>",array('controller' => 'walls', 'action' => 'add'),array('escape' => false)); ?></li>
        </ul>
    </li>
    <!-- Optionally, you can add icons to the links -->
    <li class="treeview"><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".__dbt('Users')."</span>",array('controller' => 'users', 'action' => 'index'),array('escape' => false)); ?>
        <ul class="treeview-menu" >
          <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "<span>".__dbt('List Users')."</span>",array('controller' => 'users', 'action' => 'index'),array('escape' => false)); ?></li>
          <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-fw fa-user-plus')) . "<span>".__dbt('Add Users')."</span>",array('controller' => 'users', 'action' => 'add'),array('escape' => false)); ?></li>
        </ul>
    </li>
    
  </ul>
  <!-- /.sidebar-menu -->
</section>

      
      
     