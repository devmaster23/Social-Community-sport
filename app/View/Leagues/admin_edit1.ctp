<section class="content-header">
	<h1><?php echo __dbt('League'); ?>
	  <small><?php echo __dbt('Admin Edit League'); ?></small>
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
						<?php echo $this->Form->create('League',array('class'=>'form-horizontal')); ?>
						<?php echo $this->Form->input('id'); ?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('League Name'); ?></label>
							<div class="col-sm-4">
								<?php echo $this->Form->input('name', array("class"=>"form-control",'label' => false,'required'=>false)); ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Sport'); ?></label>
							<div class="col-sm-4">
								<?php //echo $this->Form->input('sport_id', array("class"=>"form-control",'label' => false, "empty"=>"Please Select", "onchange"=>"getTournaments(this);",'required'=>false));  ?>
								
								<?php echo $this->Form->input('sport_id', array("class"=>"form-control",'label' => false, 'required'=>false));  ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Tournament'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php echo $this->Form->input('tournament_id', array("class"=>"form-control",'label' => false, "empty"=>"Please Select",'required'=>false));  ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('No of Teams'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php echo $this->Form->input('no_of_teams', array("class"=>"form-control",'label' => false, "empty"=>"Please Select",'required'=>false));  ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Start Date'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php echo $this->Form->input('start_date', array('type'=>'text','data-field'=>'datetime',"class"=>"form-control",'label' => false, "empty"=>"Please Select",'required'=>false));  ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('End Date'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php echo $this->Form->input('end_date', array('type'=>'text','data-field'=>'datetime',"class"=>"form-control",'label' => false, "empty"=>"Please Select",'required'=>false));  ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Host'); ?></label>
							<div class="col-sm-4">
								<?php echo $this->Form->input('host', array("class"=>"form-control",'label' => false,'required'=>false));  ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Moderator'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php echo $this->Form->input('user_id', array("class"=>"form-control",'label' => false, "empty"=>"-- Select League Moderator --",'required'=>false));  ?>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="inputEmail3"><?php echo __dbt('Status'); ?></label>
							<div class="col-sm-4" id="tournament-box">
								<?php $status_options = array("Inactive", "Active");
									echo $this->Form->input('status', array("type"=>"select","options"=>$status_options,"class"=>"form-control",'label' => false,"empty"=>"Select Status"));  ?>
							</div>
						</div>
						<div class="box-footer">
							<div class="col-sm-4 control-label">
							<?php echo $this->Form->submit('Update',array('type' => 'submit','class'=>'btn btn-primary','div'=>false)); ?>
							<a class="btn btn-warning margin" href="/admin/leagues"><?php echo __dbt('Cancel'); ?></a>
                                                        </div>
						</div>
						<?php echo $this->Form->end(); ?>
				</div>


		</div>
	  </div>
	</div>
</section>

<div id="dtBox1"></div><!-- this div used for date picker  -->

<script type="text/javascript">
        $(document).ready(function(){
		$("#dtBox1").DateTimePicker({					
			dateTimeFormat: "yyyy-MM-dd hh:mm:ss"			
		});

		var url = "<?php echo $this->Html->url(array("controller"=>"Leagues", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode('<?php echo $sportId['League']['sport_id'];?>');
		$.post(url, {id:"id"}, function(data){
		$("#tournament-box").html(data);
		jQuery('#LeagueTournamentId').val(jQuery('#LeagueTournamentId').children('option:nth-child(2)').val());
		});
	});


    function getTournaments(obj){
        var jQ = $(obj);
        var url = "<?php echo $this->Html->url(array("controller"=>"Leagues", "action"=>"getTournamentsAjax", $this->params["prefix"] => false)); ?>/"+Base64.encode(jQ.val());
        $.post(url, {id:"id"}, function(data){
            $("#tournament-box").html(data);
        });
    }
</script>
