
<aside class="sidebar sidebar-new">                      	
<ul class="sidebar-nav">
     <li>
        <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-tachometer')) . __dbt("Dashboard"),array('controller' => 'dashboard', 'action' => 'index','blogger'=>true),array('escape' => false)); ?>
    </li>
     <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-file-picture-o')) . __dbt("Profile Settings"),array('controller' => 'dashboard', 'action' => 'myProfile','blogger'=>true),array('escape' => false)); ?>
     </li>
     <!--li>
         < ?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "Teams",array('controller' => 'userTeams', 'action' => 'index','blogger'=>true),array('escape' => false)); ?>
     </li>
     <li>
         < ?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . "Wall",array('controller' => 'walls', 'action' => 'add','blogger'=>true),array('escape' => false)); ?>
     </li-->
     <?php if(AuthComponent::User('sportSession.sport_id')) { ?>
     <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-file-movie-o')) . __dbt("YouTube Video"),array('controller' => 'bloggers', 'action' => 'share_video','blogger'=>true),array('escape' => false)); ?>
     </li>
    <?php  } ?>
    
</ul>
<div class="side-banner">
    <img src="/img/side-banner.jpg" alt="Banner" title="Banner" />
</div>
<div class="like-us">
        <h4>Like us on</h4>
    <span><a href="#"><img src="/img/twitter.png" alt="" /></a><a href="#"><img src="/img/fbicon.png" alt="" /></a><a href="#"><img src="/img/g+icon.png" alt="" /></a></span>
</div>
</aside>
