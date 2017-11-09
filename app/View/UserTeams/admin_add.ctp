<section class="content-header">
	<h1><?php echo __dbt('User Teams'); ?>
	  <small><?php echo __dbt('Assign Team To User'); ?></small>
	</h1>
	 <?php echo $this->element($elementFolder.'/breadcrumb'); ?>
</section>
<section class="content">
	<div class="row">
	  <div class="col-md-12">
		<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"></h3>
				</div>
				<div class="box-body">
				<?php echo $this->Form->create('UserTeam',array('class'=>'form-horizontal', 'autocomplete'=>"off")); ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('User'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('user_id', array("class"=>"form-control",'label' => false)); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Sport'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('sport_id', array("class"=>"form-control",'label' => false, "empty"=>"Please Select", "onchange"=>"getTournaments(this);")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament'); ?></label>
						<div class="col-sm-4" id="tournament-box">
						<?php echo $this->Form->input('tournament_id', array("class"=>"form-control",'label' => false, "empty"=>"Please Select", "onchange"=>"getLeagues(this);")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('League'); ?></label>
						<div class="col-sm-4" id="league-box">
						<?php echo $this->Form->input('league_id', array("class"=>"form-control",'label' => false, "empty"=>"Please Select", "onchange"=>"getTeams(this);")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team'); ?></label>
						<div class="col-sm-4" id="team-box">
						<?php echo $this->Form->input('team_id', array("class"=>"form-control",'label' => false, "empty"=>"Please Select")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
						<?php $status_options = array("Inactive", "Active", "Archived");
						echo $this->Form->input('status', array("type"=>"select", "value"=>"1", "options"=>$status_options,"class"=>"form-control",'label' => false)); ?>
						</div>
					</div>
					
					<div class="box-footer">
						<div class="col-sm-3 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary btn-flat','div'=>false)); ?>
						</div>
					</div>
			        </div>
		</div>
	  </div>
	</div>
</section>

<script>
    function getTournaments(obj){
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"userTeams", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){Asghar Stanikzai 
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