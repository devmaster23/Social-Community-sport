<section>
 <div class="lp">
      
        <?php 
            if(!isset($auth_error) && !isset($reg_errors)){
                echo $this->Flash->render(); 
            }
        ?> 
       <?php echo $this->Common->topNavSports(AuthComponent::User('id')); ?>
     <div class="event-title">
     <div class="inn-title">
            <h2><i class="fa fa-check" aria-hidden="true"></i><?php echo __dbt(' Dashboard'); ?></h2>
      </div>  
</div>
     
      <!-- Inner wrap start -->
      <div class="inner-wrap">
        <div class="row">
  

        <!-- Sidebar end -->
        <!-- Main content start -->
        <div class="col-sm-9 wdth-custom-7">
            <div class="main-content">

                <?php $teamCount = 0;if(!empty($userTeams)) {  ?>
                <div class="post-main dashhboard-main-post">
                    <div class="row">
                     <?php foreach($userTeams as $teams):
                         $teamCount++;
                         ?>
                        <div class="col-md-3">
                            <!-- small box -->
                            <div class="hom-trend">
                                <div><h3> <?php echo __dbt($teams['Team']['name']); ?> </h3></div>
                                    <div class="hom-trend-img">
                                        <?php echo $this->Sport->showTileImage($teams['Sport']['tile_image']); ?>
                                    </div>
                                    <div class="hom-trend-con dashbordhom-trend">
                                    
                                    <h4><?php echo __dbt($teams['Tournament']['name']); ?></h4>
                                      
                                   <h5> <?php echo __dbt($teams['League']['name']); ?> <br><h5>
                            
                                            
                                              
                                    </div>    

                                <?php
                                if($teams['UserTeam']['status'] == 3) {
                                  echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-check-square-o')) .' '. __dbt("Join New Team"),array('controller' => 'userTeams', 'action' => 'add'),array('escape' => false,"class"=>"small-box-footer small-box1 morebtn hvr-sweep-to-right"));   
                                  
                                  echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-refresh')).' '. __dbt("Rejoin Team"),array('controller' => 'userTeams', 'action' => 'rejoin',base64_encode($teams['UserTeam']['id'])),array('escape' => false,"class"=>"small-box-footer small-box2 morebtn hvr-sweep-to-right")); 
                                } else if($teams['UserTeam']['status'] == 2) {
                                    echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa   fa-expeditedssl')).__dbt(" Your Rejoin Request On Hold."), 'javascript:void(0)', array('escape' => false,"class"=>"small-box-footer morebtn hvr-sweep-to-right"));

                                } else {
                                    echo $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')). __dbt("More Info"),array('controller' => 'dashboard', 'action' => 'startTeamSession',base64_encode($teams['UserTeam']['team_id']),base64_encode($teams['UserTeam']['tournament_id']),base64_encode($teams['UserTeam']['league_id']),base64_encode($teams['UserTeam']['sport_id'])),array('escape' => false,"class"=>"morebtn hvr-sweep-to-right")); 
                                }
                               ?>
                            </div>
                            <!-- small box -->
                        </div>
                     <?php  endforeach;
                       for($team=1; $team<=(3-$teamCount); $team++){ ?>
                        <div class="col-md-3">
                            <!-- small box -->
                            <div class="hom-trend">
                                <div class="inner">
                                    <h3 style="display: none;"><?php echo __dbt('Add New Team'); ?></h3>
                                        <div class="img-fix">
                                            <?php echo $this->Html->image('defaultSport.jpg',array('class' => 'img-responsive'));?>
                                        </div>
                                    <div class="text-fix">
                                        <p><?php echo __dbt('Click below to join new team.'); ?>
                                        </p>
                                    </div>
                                </div>
                                <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')) . __dbt("Join New Team"),array('controller' => 'userTeams', 'action' => 'add'),array('escape' => false,"class"=>"small-box-footer morebtn hvr-sweep-to-right")); ?>
                            </div>
                            <!-- small box -->
                        </div>
                    <?php } ?>   
                    </div>
                </div>
                <?php } else {  ?>
               <!-- if no team selected --> 
               <div class="post-main dashhboard-main-post">
               <div class="row">
               <?php        for($team=1; $team<=3; $team++){ ?>
                                <div class="col-lg-6 col-xs-6 margin-bt-30">
                                    <!-- small box -->
                                    <div class="small-box bg-red x-bx-dsgn">
                                        <div class="inner">
                                            <h3 style="display: none;"><?php echo __dbt('Add New Team'); ?></h3>
                                                <div class="img-fix">
                                                    <?php echo $this->Html->image('defaultSport.jpg',array('class' => 'img-responsive'));?>
                                                </div>
                                            <div class="text-fix">
                                                <p><?php echo __dbt('Click  below to join new team.'); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right')) . __dbt("Join New Team"),array('controller' => 'userTeams', 'action' => 'add'),array('escape' => false,"class"=>"small-box-footer morebtn hvr-sweep-to-right")); ?>
                                    </div>
                                    <!-- small box -->
                                </div>
                    <?php  } ?> 
                </div>
                    </div>
                    <?php } ?>
            </div>
        </div>
        <!-- Main content end -->
       <!-- Right sidebar start -->
        <div class="col-sm-3 custom-wdth-col3"> 
            <div class="rgt-sidebar">
                <div class="top-banner">
                    <img src="/img/top-banner.jpg" />
                </div>
                <div class="top-banner">
                    <img src="/img/top-banner.jpg" />
                </div>
            </div>
        </div>    
       <!-- Right sidebar end--> 
        </div> 
      </div>  
      <!-- Inner wrap end -->
   </div>
</section>