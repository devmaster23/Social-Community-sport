<?php if($this->params['controller']=='Sports'){?>
<div class="close_nav_list"><i class="fa fa-bars"></i> <i class="fa fa-times"></i></div> 
    <div id="leagueMenu">
    <?php if(!empty($sportLeagues)) { ?>

       
    <h3><?php echo $sportLeagues[0]['Sport']['name']; ?></h3>
        <ul> 
            <?php foreach($sportLeagues as $league): ?>
            <li><a href="Javascript:void(0)"><i class="fa fa-chevron-right"></i><?php echo __dbt($league['League']['name']);?></a>
                </li>
            <?php endforeach; ?>
            <?php if($totalSportLeague > 10){?>
            <li><?php echo $this->Html->link('View all leagues',array('controller'=>'StaticPages','action'=>'viewLeague',base64_encode($sportLeagues[0]['Sport']['id'])))?></li>
            <?php }?>
        </ul>
<?php }
else{ ?>
    <ul> 
        <h3> &nbsp;</h3>
            <li><a href="Javascript:void(0)"><i class="fa fa-chevron-right"></i><?php echo __dbt("No League Found");?></a>
                </li>

        </ul>
    
<?php }?>
    <a href="<?php echo BASE_URL; ?>" id="backButton"><?php echo __dbt('Back To Menu');?></a>
    </div><?php
}else{?>
    <div id="mainMenu" <?php if(!empty($sportLeagues)) echo 'style=display:none';  ?> >
    <div class="close_nav_list"><i class="fa fa-bars"></i> <i class="fa fa-times"></i></div>

    <h3><?php echo __dbt('Menu'); ?></h3>
        <ul>
            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . __dbt("Cricket"),array('controller' => 'Sports', 'action' => 'sport',1, $this->params['prefix']=>false),array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . __dbt("Soccer"),array('controller' => 'Sports', 'action' => 'sport',2, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . __dbt("Football"),array('controller' => 'Sports', 'action' => 'sport',3, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . __dbt("Hockey"),array('controller' => 'Sports', 'action' => 'sport',4, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . __dbt("Baseball"),array('controller' => 'Sports', 'action' => 'sport',5, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-chevron-right')) . __dbt("Basketball"),array('controller' => 'Sports', 'action' => 'sport',6, $this->params['prefix']=>false),array('escape' => false)); ?></li>
        </ul>
    </div>
<?php }?>
    <script>
   /* $(document).on('click','#backButton',function(){
       $('#mainMenu').css('display','block');
       $('#leagueMenu').css('display','none');
    });*/
    $(document).ready(function(){
        
        $(".close_nav_list").click(function(){
        $(".pushmenu").removeClass("pushmenu-open");    
        });
    });
    </script>
            
            