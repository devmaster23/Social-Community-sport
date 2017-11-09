<section class="content-header">
	<h1><?php echo __dbt('Edit Team'); ?>
	  <small><?php echo __dbt('Admin Edit Team'); ?></small>
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
				<?php echo $this->Form->create('Team',array('class'=>'form-horizontal', 'autocomplete'=>"off")); ?>
				   <?php echo $this->Form->input('id'); ?>	
                                    <div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team Name'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Enter team name','label' => false, 'autocomplete'=>"off")); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament'); ?></label>
						<div class="col-sm-4" id="tournament-box">
						<?php echo $this->Form->input('tournament_id',array('class'=>'form-control','empty'=>'Select Tournament ','label' => false,"onchange"=>"getLeagues(this);",'disabled'=>true)); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Team Admin'); ?></label>
						<div class="col-sm-4">
						<?php echo $this->Form->input('user_id',array('class'=>'form-control','label' => false,'empty'=>'-- Select Team Admin --')); ?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
						<div class="col-sm-4">
						<?php $status_options = array("Inactive", "Active");
						echo $this->Form->input('status', array("type"=>"select", "options"=>$status_options,"class"=>"form-control",'label' => false,'empty'=>'-- Select status --')); ?>
						</div>
					</div>
					
					<div class="box-footer">
						<div class="col-sm-4 control-label">
						<?php echo $this->Form->submit('Submit',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
						<a class="btn btn-warning margin" href="/league/teams"><?php echo __dbt('Cancel'); ?></a>
                                                </div>
					</div>
			        </div>
		</div>
	  </div>
	</div>
</section>

<script>
    function getLeagues(obj){
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Teams", "action"=>"getLeaguesAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
            $("#league-box").html(data);
        });        
    }
</script>
