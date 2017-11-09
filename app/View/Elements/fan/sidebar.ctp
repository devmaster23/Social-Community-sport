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

</aside>
