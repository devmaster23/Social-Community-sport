<div class="main-wrap">
    <div class="container">
	<?php echo $this->Flash->render();?> 
        <div class="row join_team-layout wrap-shrt-cntnr">
            <!-- left column -->
            <div>
             <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><span><?php echo __dbt('Select Your Team'); ?></span></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo $this->Form->create('UserTeam',array('novalidate' => true,'div'=>false)); 
                echo $this->Form->input('user_id', array('type'=>'hidden',"value"=>$users,"class"=>"form-control",'label' => false)); 
                ?>
                
		
                  <div class="box-body">
                    <div class="form-group">
                      <label for="sp"><?php echo __dbt('Sport'); ?> </label>
                      <?php echo $this->Form->input('sport_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select Sport"), "onchange"=>"getTournaments(this);"));?>
                      
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo __dbt('Tournament'); ?> </label>
                        <div id="tournament-box">
                        <?php     echo $this->Form->input('tournament_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select Tournament"), "onchange"=>"getLeagues(this);",'div'=>false));  ?>
                        </div> 
                      
                      
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo __dbt('League'); ?> </label>
                        <div id="league-box">
                             <?php echo  $this->Form->input('league_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select League"), "onchange"=>"getTeams(this);",'div'=>false)); ?>
                        </div> 
                      
                      
                    </div>
                  </div>
                <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1"><?php echo __dbt('Team'); ?> </label>
                       <div id="team-box">
                        <?php  echo $this->Form->input('team_id', array("class"=>"form-control",'label' => false, "empty"=>__dbt("Please Select Team"),'div'=>false));  ?>
                           </div>
                     
                      
                    </div>
                  </div>
                <!-- /.box-body -->

                  <div class="box-footer">
                    <?php echo $this->Html->link(__dbt('Dashboard'),'/dashboard',array('class' => 'btn btn-info btn-sm pull-right'));?>
                    <?php echo $this->Form->submit(__dbt('Submit'),array('class'=>'btn btn-info btn-sm pull-right','style'=>'float:left !important')); ?>
                   
                  </div>
                 <?php echo $this->Form->end(); ?>
              </div><!-- /.box -->
            </div>      
        </div>  
    </div>
</div>


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
