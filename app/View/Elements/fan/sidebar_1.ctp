<?php
switch (AuthComponent::User('sportSession.sport_id')) {
    case 1:
        $action = 'cricketScheduling';
        break;
    case 2:
        $action = 'soccerScheduling';
        break;
    case 3:
        $action = 'footballScheduling';
        break;
    case 4:
        $action = 'hockeyScheduling';
        break;
    case 5:
        $action = 'baseballScheduling';
        break;
    case 6:
        $action = 'basketballScheduling';
        break;
    
}
?>

<aside class="sidebar sidebar-new">                      	
<ul class="sidebar-nav">
    
    <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-tachometer')) . __dbt("Dashboard"),array('controller' => 'dashboard', 'action' => 'index'),array('escape' => false)); ?>
    </li>
    <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-user-secret')) . __dbt("Profile Settings"),array('controller' => 'dashboard', 'action' => 'myProfile'),array('escape' => false)); ?>
    
    </li>
    <?php if(isset($action)) { ?>
    <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-users')) . __dbt("Team"),array('controller' => 'userTeams', 'action' => 'index'),array('escape' => false)); ?>
    </li>
    <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-shield')) . __dbt("Game Prediction"),array('controller' => 'games', 'action' => $action),array('escape' => false)); ?>
    </li>
    <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-commenting')) . __dbt("Wall"),array('controller' => 'walls', 'action' => 'index'),array('escape' => false)); ?>
    </li>
    <li>
         <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pie-chart')) . __dbt("Forum & Poll"),array('controller' => 'PollCategories', 'action' => 'polls'),array('escape' => false)); ?>
    </li>
    <?php } ?>
    
    
     
</ul>
<div class="side-banner">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- dfg -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-3044137300952276"
         data-ad-slot="2970998543"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
   
</div>
<div class="like-us">
        <h4><?php __dbt('Like us on'); ?></h4>
    <span><a href="#"><img src="/img/twitter.png" alt="" /></a><a href="#"><img src="/img/fbicon.png" alt="" /></a><a href="#"><img src="/img/g+icon.png" alt="" /></a></span>
</div>
</aside>
