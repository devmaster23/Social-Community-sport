  


<section>
        <div class="booking-bg-s lp">
            <div class="booking-bg-1">
                <div class="bg-book">
                    <div class="spe-title-1 spe-title-wid">
                        <h3><?php echo __dbt('Select Your Team'); ?></h3>
                        <div class="hom-tit">
                            <div class="hom-tit-1"></div>
                            <div class="hom-tit-2"></div>
                            <div class="hom-tit-3"></div>
                        </div>
                    </div>
                    <div class="book-succ">Thank you for join our Club.</div>
                    <div class="book-form">
             <?php echo $this->Form->create('UserTeam',array('novalidate' => true,'class' => 'form-horizontal','div'=>false)); 
                echo $this->Form->input('user_id', array('type'=>'hidden',"value"=>$users,"class"=>"form-control",'label' => false)); 
                ?>
                                            <div class="form-group">
                                <label class="control-label col-sm-2"><?php echo __dbt('Sport'); ?></label>
                                <div class="col-sm-10">
                                     <?php echo $this->Form->input('sport_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select Sport"),'div'=>false, "onchange"=>"getTournaments(this);"));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2"><?php echo __dbt('Tournament'); ?></label>
                                <div class="col-sm-10">
                                          <div id="tournament-box">
                        <?php     echo $this->Form->input('tournament_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select Tournament"), "onchange"=>"getLeagues(this);",'div'=>false));  ?>
                                </div> </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2"><?php echo __dbt('League'); ?></label>
                                <div class="col-sm-10"> <div id="league-box">
                             <?php echo  $this->Form->input('league_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select League"), "onchange"=>"getTeams(this);",'div'=>false)); ?>
                                </div>  </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2"><?php echo __dbt('Team'); ?></label>
                                <div class="col-sm-10"><div id="team-box">
                               <?php  echo $this->Form->input('team_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select Team"),'div'=>false));  ?>

                                </div></div>
                            </div>
                           
                                <div class="form-group">

                                <div class="col-sm-12">
                    <?php echo $this->Form->submit(__dbt('Submit'),array('class'=>'btn btn-info btn-sm pull-right','style'=>'float:left !important')); ?>

                                </div>
                                                                    <div class="col-sm-12">
                                    <?php echo $this->Html->link(__dbt('Dashboard'),'/dashboard',array('class' => 'dashbordbtn-join btn btn-info btn-sm pull-right'));?>
</div>
                            </div>
           
                                        <?php echo $this->Form->end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>



<script>
    function getTournaments(obj){
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"userTeams", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
            $("#tournament-box").html(data);
        });
    }
    
    function getLeagues(obj){
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"userTeams", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
            $("#league-box").html(data);
        });        
    }
    
    function getTeams(obj){
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"userTeams", "action"=>"getTeamsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
            $("#team-box").html(data);
        });        
    }
</script>
