  <!--SECTION: LEFT MENU-->
    <section>
     
          
<?php if($this->params['controller']=='Sports'){?>
    <!-- LEFT SIDE NAVIGATION MENU -->
        <div class="menu leaguemenu">
            <ul> 
    <?php if(!empty($sportLeagues)) { ?>

       
        <ul> 
                          <li class="menubackbtn"> <a href="<?php echo BASE_URL; ?>" id="backButton"><?php echo __dbt('Back To Menu');?></a></li>

            <li><a href="#"><img src="images/icon_names/<?php echo $sportLeagues[0]['Sport']['name']; ?>.png" /><?php echo $sportLeagues[0]['Sport']['name']; ?></a></li>
            <?php foreach($sportLeagues as $league): ?>
            <li><a href="Javascript:void(0)"><?php echo __dbt($league['League']['name']);?></a>
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
                                  <li class="menubackbtn"> <a href="<?php echo BASE_URL; ?>" id="backButton"><?php echo __dbt('Back To Menu');?></a></li>

            <li><a href="Javascript:void(0)"><i class="fa fa-chevron-right"></i><?php echo __dbt("No League Found");?></a>
                </li>

        </ul>
     </div>
<?php }?>
    <?php
}else{?>
  
  <!--SECTION: LEFT MENU-->
        <!-- LEFT SIDE NAVIGATION MENU -->
        <div class="menu">
        <ul>
                                 <!-- MAIN MENU -->
                <li>
                    <a href="/" class="menu-lef-act"><img src="/images/icon/s1.png" alt=""> Home</a>
                </li>
            <li><?php echo $this->Html->link($this->Html->tag('img', '', array('src' => '/images/icon/c3.png')) . __dbt("Cricket"),array('controller' => 'Sports', 'action' => 'sport',1, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('img', '', array('src' => '/images/icon/f2.png')) . __dbt("Soccer"),array('controller' => 'Sports', 'action' => 'sport',2, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('img', '', array('src' => '/images/icon/s7.png')) . __dbt("Football"),array('controller' => 'Sports', 'action' => 'sport',3, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('img', '', array('src' => '/images/icon/S15.png')) . __dbt("Hockey"),array('controller' => 'Sports', 'action' => 'sport',4, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('img', '', array('src' => '/images/icon/S5.png')) . __dbt("Baseball"),array('controller' => 'Sports', 'action' => 'sport',5, $this->params['prefix']=>false),array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link($this->Html->tag('img', '', array('src' => '/images/icon/S13.png')) . __dbt("Basketball"),array('controller' => 'Sports', 'action' => 'sport',6, $this->params['prefix']=>false),array('escape' => false)); ?></li>
        </ul>
    </div>
<?php }?>
    </ul>
       

        <!-- RIGHT SIDE NAVIGATION MENU -->
        <!-- MOBILE MENU(This mobile menu show on 0px to 767px windows only) -->
        <div class="mob-menu">
            <span><i class="fa fa-bars" aria-hidden="true"></i></span>
        </div>
        <div class="mob-close">
            <span><i class="fa fa-times" aria-hidden="true"></i></span>
        </div>
    </section>

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
            
            
    
    
    
    
  